<?php
namespace YoLaile\Library\Support\File;

class AliYunBucketEnum
{
    /** @var string 图片存储桶 共有权限 */
    protected const YO_IMAGES  = 'yolaile';
    /** @var string 文件存储桶 私有权限 */
    protected const YO_FILE  = 'yolaile-file';

    /**
     * 获取图片存储桶
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 14:27
     */
    public static function getImageBucket():string
    {
        return self::YO_IMAGES;
    }

    /**
     * 获取文件存储桶
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 14:28
     */
    public static function getFileBucket():string
    {
        return self::YO_FILE;
    }
}