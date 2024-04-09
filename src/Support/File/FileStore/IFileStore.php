<?php
namespace YoLaile\Library\Support\File\FileStore;

use YoLaile\Library\Support\File\FileHttpInfo;
use YoLaile\Library\Support\File\FileStore\Drive\IDriver;

/**
 * 文件存储定义接口
 * @package YoLaile\Library\Support\File\FileStore
 *
 * @author  Giles <giles.wang@aliyun.com|giles.wang@qq.com>
 * @date    2024/3/22 09:44
 */
interface IFileStore
{
    /**
     * 上传图片方法
     *
     * @param string $imagesPath 本地图片文件路径
     * @param string $fileName   文件名
     * @return FileHttpInfo
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/3/22 09:47
     */
    public function uploadImages(string $imagesPath, string $fileName):FileHttpInfo;

    /**
     * 上传附件类文件 包括excel 、docs、csv、jar等文件 暂时不做强制校验
     *
     * @param string $path     本地文件路径
     * @param string $fileName 文件名称
     * @return FileHttpInfo
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/3/22 09:47
     */
    public function uploadFile(string $path, string $fileName):FileHttpInfo;
}