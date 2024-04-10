<?php
namespace YoLaile\Library\Component\Microserver\Core;

/**
 *
 * 服务发现的信息约定
 * @package YoLaile\Library\Component\Microserver\Core
 *
 * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
 * @date 2024/4/3 14:07
 */
class Convention
{
    /** @var string 请求协议模式 */
    private $scheme;
    /** @var string 请求主机 */
    private $host;
    /** @var int 端口号 */
    private $port;
    /** @var string 请求URI */
    private $uri;
    /** @var string 请求的方法 */
    private $method;
    /** @var array 请求参数列表 */
    private $params;
    /** @var string 请求版本号 */
    private $version;
    /** @var string 签名方法 */
    private $signWay;
    /** @var string 方法名 */
    private $actionName;
    private $serviceName;

    /**
     * @param string $scheme
     * @param string $host
     * @param int $port
     * @param string $uri
     * @param string $method
     * @param string $params
     * @param string $version
     * @param string|null $signWay
     * @param string $serviceName
     * @param string $actionName
     */
    public function __construct(
        string $scheme,
        string $host,
        int $port,
        string $uri,
        string $method,
        string $params,
        string $version,
        string $signWay = '',
        string $serviceName,
        string $actionName = ''
    ) {
        $this->scheme      = $scheme;
        $this->host        = $host;
        $this->port        = $port;
        $this->uri         = ltrim($uri, '/');
        $this->method      = $method;
        $this->params      = explode(',', $params);
        $this->version     = $version;
        $this->signWay     = $signWay;
        $this->serviceName = $serviceName;
        $this->actionName  = $actionName;
    }

    /**
     * getScheme
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 19:56
     */
    public function getScheme(): string
    {
        return $this->scheme;
    }

    /**
     * getHost
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 19:56
     */
    public function getHost(): string
    {
        return $this->host;
    }

    /**
     * getPort
     *
     * @return int
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 19:57
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * getUri
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 19:57
     */
    public function getUri(): string
    {
        return $this->uri;
    }

    /**
     * getMethod
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 19:57
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * getParams
     *
     * @return array
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 19:57
     */
    public function getParams(): array
    {
        return $this->params;
    }

    public function getSignWay():string
    {
        return $this->signWay;
    }

    /**
     * getVersion
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 19:57
     */
    public function getVersion(): string
    {
        return $this->version;
    }

    /**
     * getActionName
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 19:57
     */
    public function getActionName(): string
    {
        return $this->actionName;
    }

    public function getServiceName(): string
    {
        return $this->serviceName;
    }
}