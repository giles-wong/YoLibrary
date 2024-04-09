<?php
namespace YoLaile\Library\Support\File;

/**
 * Class FileMetaInfo 文件元信息类
 *
 * @package YoLaile\Library\Support\File\FileStore
 *
 * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
 * @date 2024/3/22 09:35
 */
class FileMetaInfo
{
    /** @var string 文件名 */
    private $name = '';

    /** @var int 文件大小单位字节 */
    private $sizeByte = 0;

    /** @var string 文件MimeType */
    private $mimeType = '';

    /** @var string 文件路径 */
    private $path = '';

    /** @var string 放入哪个桶 */
    private $bucket;

    /**
     * @param string $name
     * @param int    $size
     * @param string $mimeType
     * @param string $path
     */
    public function __construct(string $name, int $size, string $mimeType, string $path, string $bucket)
    {
        $this->name     = $name;
        $this->sizeByte = $size;
        $this->mimeType = $mimeType;
        $this->path     = $path;
        $this->bucket   = $bucket;
    }

    /**
     * 获取文件名
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 13:51
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * 文件大小
     *
     * @return int
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 13:51
     */
    public function getSizeByte(): int
    {
        return $this->sizeByte;
    }

    /**
     * 文件类型
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 13:51
     */
    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    /**
     * 文件位置
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 13:52
     */
    public function getPath(): string
    {
        return $this->path;
    }

    /**
     * 放入哪个桶 文件存在位置
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 14:05
     */
    public function getBucket():string
    {
        return $this->bucket;
    }
}