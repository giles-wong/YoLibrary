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

    /** @var string 对外展示路径 */
    private $showPath = '';

    /**
     * @param string $name
     * @param int $size
     * @param string $mimeType
     * @param string $path
     * @param string $showPath
     */
    public function __construct(string $name, int $size, string $mimeType, string $path, string $showPath = '')
    {
        $this->name     = $name;
        $this->sizeByte = $size;
        $this->mimeType = $mimeType;
        $this->path     = $path;
        $this->showPath = $showPath;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSizeByte(): int
    {
        return $this->sizeByte;
    }

    public function getMimeType(): string
    {
        return $this->mimeType;
    }

    public function getPath(): string
    {
        return $this->path;
    }

    public function getShowPath(): string
    {
        return $this->showPath;
    }
}