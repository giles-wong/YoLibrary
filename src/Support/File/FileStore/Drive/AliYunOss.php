<?php
namespace YoLaile\Library\Support\File\FileStore\Drive;

use OSS\OssClient;
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
        $this->accessKeyId     = $config['key_id'];
        $this->accessKeySecret = $config['key_secret'];
        $this->endpoint        = $config['endpoint'];
        $this->bucket          = $config['bucket'];
        $this->domain          = $config['domain'];

        $this->ossClient = new OssClient($this->accessKeyId, $this->accessKeySecret, $this->endpoint);
    }

    public function upload(FileMetaInfo $metaInfo):FileHttpInfo
    {
        $showFilePath = '';

        $result = $this->ossClient->uploadFile($this->bucket, $showFilePath, $metaInfo->getPath());

        dd($result);
    }
}