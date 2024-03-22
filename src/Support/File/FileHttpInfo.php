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
    /** @var string|null 文件HTTP URL地址 */
    private $httpUrl = null;

    /** @var string|null 文件HTTPS URL地址 */
    private $httpsUrl = null;

    /** @var string|null 文件唯一ID */
    private $fileId = null;

    /** @var string|null 文件MD5 */
    private $md5 = null;

    /** @var string|null 访问加密文件时的Token */
    private $token = null;

    /**
     * FileHttpInfo constructor.
     *
     * @param string $httpUrl
     * @param string $httpsUrl
     * @param string $fileId
     * @param string $md5
     * @param string $token
     */
    public function __construct(string $httpUrl, string $httpsUrl, string $fileId, string $md5, string $token)
    {
        $this->httpUrl  = $httpUrl;
        $this->httpsUrl = $httpsUrl;
        $this->fileId   = $fileId;
        $this->md5      = $md5;
        $this->token    = $token;

        return $this;
    }

    public function getHttpUrl(): ?string
    {
        return $this->httpUrl;
    }

    public function getHttpsUrl(): ?string
    {
        return $this->httpsUrl;
    }

    public function getFileId(): ?string
    {
        return $this->fileId;
    }

    public function getMd5(): ?string
    {
        return $this->md5;
    }

    public function getToken(): ?string
    {
        return $this->token;
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
            'fileId'   => $this->fileId,
            'httpUrl'  => $this->httpUrl,
            'httpsUrl' => $this->httpsUrl,
            'md5'      => $this->md5,
            'token'    => $this->token,
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
            'httpUrl'  => $this->httpUrl,
            'httpsUrl' => $this->httpsUrl,
            'fileId'   => $this->fileId,
            'md5'      => $this->md5,
            'token'    => $this->token,
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
            'httpUrl'  => $this->httpUrl,
            'httpsUrl' => $this->httpsUrl,
            'fileId'   => $this->fileId,
            'md5'      => $this->md5,
            'token'    => $this->token,
        ], JSON_UNESCAPED_UNICODE);
    }
}