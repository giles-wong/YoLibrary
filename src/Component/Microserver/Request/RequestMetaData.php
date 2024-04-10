<?php
namespace YoLaile\Library\Component\Microserver\Request;

use YoLaile\Library\Component\Microserver\Core\Convention;
use YoLaile\Library\Component\Microserver\Core\Exception\DispatcherException;
use YoLaile\Library\Convention\Exception\ServiceErrorException;
use YoLaile\Library\Snowflake;

/**
 *
 * 单次请求的元数据约定
 * @package YoLaile\Library\Component\Microserver\Request
 *
 * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
 * @date 2024/4/10 09:03
 */
class RequestMetaData
{
    /** @var string 请求Id */
    private $requestId;
    /** @var string 服务名 */
    private $serviceName;
    /** @var string 服务Action名称 */
    private $serviceActionName;
    /** @var array 服务Action的参数名 */
    private $serviceActionParamNames;
    /** @var array 服务Action的参数值 */
    private $serviceActionParamValues;
    /** @var string 请求URI */
    private $requestUri;
    /** @var string 请求方法(GET/POST/PUT/DELETE) */
    private $requestMethod;
    /** @var array 请求参数 */
    private $requestParams;
    /** @var array 请求头信息 */
    private $requestHeaders;
    /** @var Convention */
    private $convention;

    /**
     * __construct
     *
     * @param Convention $convention
     * @param array $businessParamValues
     * @param array $headers
     * @param string|null $requestId
     * @throws DispatcherException
     */
    public function __construct(
        Convention $convention,
        array $businessParamValues,
        array $headers = [],
        string $requestId = null
    )
    {
        if (empty($convention) || empty($businessParamValues)) {
            throw new DispatcherException('请求的服务信息缺失：ServiceName/ServiceAction/ServiceArgs');
        }
        // 请求ID
        $this->requestId     = $requestId ?? Snowflake::uniqueId();
        // 初始化请求元数据
        $this->initRequestMetaData($convention, $businessParamValues);
        $this->requestHeaders = $headers;
    }

    /**
     * initRequestMetaData 初始化请求元数据
     *
     * @param Convention $convention
     * @param array $paramValues
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/10 09:15
     */
    private function initRequestMetaData(Convention $convention, array $paramValues): void
    {
        // 获取请求参数值
        $this->serviceActionParamValues = $paramValues;
        // 获取服务和方法的调度约定信息
        $this->requestMethod           = strtoupper($convention->getMethod());
        $this->requestUri              = $convention->getScheme() . '://' . $convention->getHost() . ':'
            . $convention->getPort() . '/' . $convention->getUri();
        $this->serviceActionParamNames = $convention->getParams();
        /* 均衡请求参数的Name和值的数量 */
        // 获取可选参数的参数名
        if (!empty($this->serviceActionParamNames) && is_array($this->serviceActionParamNames)) {
            $this->serviceActionParamNames = array_map(function ($v) {
                return trim($v);
            }, $this->serviceActionParamNames);
        }
        $optionalParamNames            = preg_grep("/^(\S*)\?$/", $this->serviceActionParamNames);
        $this->serviceActionParamNames = preg_replace("/^(\S*)\?$/", '$1', $this->serviceActionParamNames);
        // 求出最小参数数量(总数量减去可选参数数量)
        $minParamLen   = count($this->serviceActionParamNames) - count($optionalParamNames);
        $paramValueLen = count($this->serviceActionParamValues);
        if ($minParamLen > $paramValueLen) { // 请求参数的必选Name数量大于value,无法拼接够对应的参数
            throw new ServiceErrorException("调用传入参数数量不足参数定义数量");
        }
        // 根据参数值的长度来截取参数名的长度,确保可变参数长度正确性
        $this->serviceActionParamNames = array_slice($this->serviceActionParamNames, 0, $paramValueLen);
        // 根据参数名的长度来截取参数值的长度,确保输入的参数值的长度最大不超过输入参数名的最大长度
        $paramNameLen                   = count($this->serviceActionParamNames);
        $this->serviceActionParamValues = array_slice($this->serviceActionParamValues, 0, $paramNameLen);
        if (count($this->serviceActionParamValues) != $paramNameLen) {
            throw new ServiceErrorException("调用传入参数值数量和参数名定义数量不匹配");
        }
        // 组装请求的参数requestParams
        //@TODO
        if(in_array(current($this->serviceActionParamNames), ['noData', 'json'])) {
            $this->requestParams = current($this->serviceActionParamValues);
        } else {
            $this->requestParams = array_combine($this->serviceActionParamNames, $this->serviceActionParamValues);
        }
    }

    /**
     * 获取请求方法
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/10 09:17
     */
    public function getMethod(): string
    {
        return $this->requestMethod;
    }

    /**
     * getRequestUri
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/10 09:17
     */
    public function getRequestUri(): string
    {
        if (strpos($this->requestUri, '{')
            && strpos($this->requestUri, '}')
            && !empty($this->requestParams)) {
            foreach ($this->requestParams as $param => $value) {
                if (!is_array($param) && strpos($this->requestUri, '{'. $param .'}')) {
                    $this->requestUri = str_replace('{'. $param .'}', $value, $this->requestUri);
                    unset($this->requestParams[$param]);
                }
            }
        }

        return $this->requestUri;
    }

    /**
     * getRequestParams
     *
     * @return array
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/10 09:18
     */
    public function getRequestParams(): array
    {
        return $this->requestParams;
    }

    /**
     * getRequestId
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/10 09:18
     */
    public function getRequestId(): string
    {
        return $this->requestId;
    }

    /**
     * getServiceActionParamNames
     *
     * @return array
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/10 09:18
     */
    public function getServiceActionParamNames ():array
    {
        return $this->serviceActionParamNames;
    }

    /**
     * getConvention
     *
     * @return Convention
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/10 09:18
     */
    public function getConvention(): Convention
    {
        return $this->convention;
    }

    /**
     * getServiceActionParamValues
     *
     * @return array
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/10 09:18
     */
    public function getServiceActionParamValues(): array
    {
        return $this->serviceActionParamValues;
    }
}