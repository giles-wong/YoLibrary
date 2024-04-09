<?php
namespace YoLaile\Library\Support\File;

/**
 *
 * Class FileHttpInfo 文件的HTTP信息
 *  使用HTTP形式获取文件时所定义的信息
 *
 * @package YoLaile\Library\Support\File
 *
 * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
 * @date 2024/3/22 09:39
 */
class FileHttpInfo
{
    /** @var string|null URL地址 */
    private $url = null;

    /** @var string|null 文件唯一ID */
    private $fileId = null;

    /** @var string|null 文件MD5 */
    private $md5 = null;

    /**
     * FileHttpInfo constructor.
     *
     * @param string $url
     * @param string $fileId
     * @param string $md5
     */
    public function __construct(string $url, string $fileId, string $md5)
    {
        $this->url    = $url;
        $this->fileId = $fileId;
        $this->md5    = $md5;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function getFileId(): ?string
    {
        return $this->fileId;
    }

    public function getMd5(): ?string
    {
        return $this->md5;
    }

    /**
     * toArray 获取数组结果
     *
     * @return array
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/3/22 09:41
     */
    public function toArray():array
    {
        return [
            'fileId' => $this->fileId,
            'url'    => $this->url,
            'md5'    => $this->md5,
        ];
    }

    /**
     * toJson 转换成JSON
     *
     * @return false|string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/3/22 09:42
     */
    public function toJson():string
    {
        return json_encode([
            'fileId' => $this->fileId,
            'url'    => $this->url,
            'md5'    => $this->md5,
        ], JSON_UNESCAPED_UNICODE);
    }

    /**
     * __toString JSON输出
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/3/22 09:42
     */
    public function __toString(): string
    {
        return json_encode([
            'fileId' => $this->fileId,
            'url'    => $this->url,
            'md5'    => $this->md5,
        ], JSON_UNESCAPED_UNICODE);
    }
}