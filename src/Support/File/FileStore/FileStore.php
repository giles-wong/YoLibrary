<?php
namespace YoLaile\Library\Support\File\FileStore;

use YoLaile\Library\Convention\Code\FileStoreCode;
use YoLaile\Library\Convention\Exception\ServiceException;
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
     * @param string $showPath   上传后对外显示的路径
     * @return FileHttpInfo
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/3/22 09:47
     */
    public function uploadImages(string $imagesPath, string $showPath = ''): FileHttpInfo
    {
        if (empty(self::$driver)) {
            throw new ServiceException(FileStoreCode::FILE_DRIVE_NOT_INIT_MSG, FileStoreCode::FILE_DRIVE_NOT_INIT);
        }

        $metaInfo = new FileMetaInfo();

        return self::$driver->upload($metaInfo);
    }

    /**
     * 上传附件类文件 包括excel 、docs、csv、jar等文件 暂时不做强制校验
     *
     * @param string $path     本地文件路径
     * @param string $showPath 上传后对外显示的路径
     * @return FileHttpInfo
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/3/22 09:47
     */
    public function uploadFile(string $path, string $showPath = ''): FileHttpInfo
    {
        if (empty(self::$driver)) {
            throw new ServiceException(FileStoreCode::FILE_DRIVE_NOT_INIT_MSG, FileStoreCode::FILE_DRIVE_NOT_INIT);
        }

        $metaInfo = new FileMetaInfo();

        return self::$driver->upload($metaInfo);
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
        empty(self::$driver) && self::$driver = new AliYunOss($config);

        return self::$driver;
    }

    private function verifyConf(array $config, int $type = 1):void
    {
        switch ($type) {
            case 1:
                $conf = ['key_id', 'key_secret', 'endpoint', 'bucket', 'domain'];
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