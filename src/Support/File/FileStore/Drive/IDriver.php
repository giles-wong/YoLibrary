<?php
namespace YoLaile\Library\Support\File\FileStore\Drive;

use YoLaile\Library\Support\File\FileHttpInfo;
use YoLaile\Library\Support\File\FileMetaInfo;

/**
 * Interface Driver 文件存储系统驱动接口
 * @package YoLaile\Library\Support\FileStore\Drive
 *
 * @author  Giles <giles.wang@aliyun.com|giles.wang@qq.com>
 * @date    2024/3/22 09:31
 */
interface IDriver
{
    /**
     * 文件上传
     *
     * @param FileMetaInfo $metaInfo
     * @return mixed
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/3/22 10:09
     */
    public function upload(FileMetaInfo $metaInfo):FileHttpInfo;

    /**
     * 获取带授权访问的 url 链接
     *
     * @param FileMetaInfo $metaInfo
     * @param int $exp
     * @return FileHttpInfo
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 14:17
     */
    public function getUrl(FileMetaInfo $metaInfo, int $exp = 60):FileHttpInfo;
}