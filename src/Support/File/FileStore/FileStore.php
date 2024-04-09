<?php
namespace YoLaile\Library\Support\File\FileStore;

use YoLaile\Library\Convention\Code\FileStoreCode;
use YoLaile\Library\Convention\Exception\ServiceException;
use YoLaile\Library\Support\File\AliYunBucketEnum;
use YoLaile\Library\Support\File\FileHttpInfo;
use YoLaile\Library\Support\File\FileMetaInfo;
use YoLaile\Library\Support\File\FileStore\Drive\AliYunOss;
use YoLaile\Library\Support\File\FileStore\Drive\IDriver;

/**
 *
 * 文件存储实现
 * @package YoLaile\Library\Support\File\FileStore
 *
 * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
 * @date 2024/3/22 09:49
 */
class FileStore implements IFileStore
{
    /** @var IDriver 文件存储的驱动 */
    private static $driver = null;

    /**
     * 上传图片方法
     *
     * @param string $imagesPath 本地图片文件路径
     * @param string $fileName   文件名
     * @return FileHttpInfo
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/3/22 09:47
     */
    public function uploadImages(string $imagesPath, string $fileName): FileHttpInfo
    {
        if (empty(self::$driver)) {
            throw new ServiceException(FileStoreCode::FILE_DRIVE_NOT_INIT_MSG, FileStoreCode::FILE_DRIVE_NOT_INIT);
        }

        $metaInfo = new FileMetaInfo(
            $fileName,
            filesize($imagesPath),
            mime_content_type($imagesPath),
            $imagesPath,
            AliYunBucketEnum::getImageBucket()
        );

        return self::$driver->upload($metaInfo);
    }

    /**
     * 上传附件类文件 包括excel 、docs、csv、jar等文件 暂时不做强制校验
     *
     * @param string $path     本地文件路径
     * @param string $fileName 文件名称
     * @return FileHttpInfo
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/3/22 09:47
     */
    public function uploadFile(string $path, string $fileName = ''): FileHttpInfo
    {
        if (empty(self::$driver)) {
            throw new ServiceException(FileStoreCode::FILE_DRIVE_NOT_INIT_MSG, FileStoreCode::FILE_DRIVE_NOT_INIT);
        }

        $metaInfo = new FileMetaInfo(
            $fileName,
            filesize($path),
            mime_content_type($path),
            $path,
            AliYunBucketEnum::getFileBucket()
        );

        return self::$driver->upload($metaInfo);
    }

    /**
     * 根据文件地址 获取授权后的访问地址
     *
     * @param string $path
     * @param int $exp 链接有效期
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 14:31
     */
    public function getFileUrl(string $path, int $exp = 60):string
    {
        $metaInfo = new FileMetaInfo(
            'fileName',
            0,
            'type',
            $path,
            AliYunBucketEnum::getFileBucket()
        );

        return self::$driver->getUrl($metaInfo, $exp);
    }

    /**
     * 初始化驱动 前期只针对 aliYun oss 进行配置
     *
     * @param array $config
     * @return IDriver
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/3/22 10:13
     */
    public function __construct(array $config)
    {
        $this->verifyConf($config);

        empty(self::$driver) && self::$driver = new AliYunOss($config);

        return self::$driver;
    }

    /**
     * 预检配置信息
     *
     * @param array $config
     * @param int $type
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 13:59
     */
    private function verifyConf(array $config, int $type = 1):void
    {
        switch ($type) {
            case 1:
                $conf = ['access_key_id', 'access_key_secret', 'endpoint', 'domain'];
                foreach ($conf as $key) {
                    if (!isset($conf[$key]) || empty($config[$key])) {
                        throw new ServiceException(
                            FileStoreCode::FILE_STORE_CONFIG_MSG,
                            FileStoreCode::FILE_STORE_CONFIG
                        );
                    }
                }
                break;
            default:
        }
    }
}