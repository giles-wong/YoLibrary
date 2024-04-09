<?php
namespace YoLaile\Library\Support\File\FileStore\Drive;

use OSS\OssClient;
use YoLaile\Library\Convention\Code\FileStoreCode;
use YoLaile\Library\Convention\Exception\ServiceLogicException;
use YoLaile\Library\Snowflake;
use YoLaile\Library\Support\File\AliYunBucketEnum;
use YoLaile\Library\Support\File\FileHttpInfo;
use YoLaile\Library\Support\File\FileMetaInfo;

/**
 *
 * 阿里云OSS 驱动
 * @package YoLaile\Library\Support\File\FileStore\Drive
 *
 * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
 * @date 2024/3/22 10:29
 */
class AliYunOss implements IDriver
{
    public $ossClient;
    public $bucket;
    public $accessKeyId;
    public $accessKeySecret;
    public $endpoint;
    public $domain;

    public function __construct(array $config)
    {
        $this->accessKeyId     = $config['access_key_id'];
        $this->accessKeySecret = $config['access_key_secret'];
        $this->endpoint        = $config['endpoint'];
        $this->domain          = $config['domain'];

        $this->ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
    }

    /**
     * 上传文件
     *
     * @param FileMetaInfo $metaInfo
     * @return FileHttpInfo
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 14:11
     */
    public function upload(FileMetaInfo $metaInfo):FileHttpInfo
    {
        try {
            $md5 = md5_file($metaInfo->getPath());
            $showFilePath = date('Ymd'). '/'. $md5 .'.'. pathinfo($metaInfo->getPath(), PATHINFO_EXTENSION);

            $contentType = $this->getContentType(pathinfo($metaInfo->getPath(), PATHINFO_EXTENSION));

            $this->ossClient->uploadFile(
                $metaInfo->getBucket(),
                $showFilePath,
                $metaInfo->getPath(),
                ['ContentType' => $contentType]
            );

            if ($metaInfo->getBucket() == AliYunBucketEnum::getImageBucket()) {
                $showFilePath = 'https://'. $this->domain.'/'. $showFilePath;
            }

            return new FileHttpInfo($showFilePath, Snowflake::uniqueId(), $md5);
        } catch (\Exception $exception) {
            throw new ServiceLogicException('上传阿里云失败:'. $exception->getMessage(), FileStoreCode::FILE_STORE_UPLOAD_ERROR);
        }
    }

    /**
     * 获取带授权访问的 url 链接
     *
     * @param FileMetaInfo $metaInfo
     * @param int $exp
     * @return FileHttpInfo
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 14:16
     */
    public function getUrl(FileMetaInfo $metaInfo, int $exp = 60):FileHttpInfo
    {
        try {
            $url = $this->ossClient->signUrl($metaInfo->getBucket(),  $metaInfo->getPath(), $exp,'GET');

            return new FileHttpInfo($url, Snowflake::uniqueId(), Snowflake::uniqueId());
        } catch (\Exception $exception) {
            throw new ServiceLogicException('获取链接失败:'. $exception->getMessage(), FileStoreCode::FILE_STORE_UPLOAD_ERROR);
        }
    }

    /**
     * 根据扩展获取文件类型
     *
     * @param string $Suffix
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 14:20
     */
    private function getContentType(string $Suffix):string
    {
        if (in_array($Suffix, ['xls'])) {
            return 'text/html';
        }
        if (in_array($Suffix, ['doc','docx'])) {
            return 'application/msword';
        }
        if (in_array($Suffix, ['png'])) {
            return 'image/png';
        }
        if (in_array($Suffix,['gif'])) {
            return 'image/gif';
        }
        if (in_array($Suffix,['avi'])) {
            return 'video/avi';
        }
        if (in_array($Suffix,['jpeg','jpg','jpe'])) {
            return 'image/jpeg';
        }
        if (in_array($Suffix,['mp3'])) {
            return 'audio/mp3';
        }
        if (in_array($Suffix,['mp4'])) {
            return 'video/mpeg4';
        }

        return '';
    }
}