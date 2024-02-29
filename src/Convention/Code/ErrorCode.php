<?php
namespace YoLaile\Library\Convention\Code;

use Throwable;
use YoLaile\Library\Convention\Exception\ServiceErrorException;

class ErrorCode
{
    const ERROR_PREFIX = "SYS_";

    const UNKNOWN_ERROR = "1";
    const UNKNOWN_ERROR_MSG = "未知的系统错误";

    const DB_ERROR = "SYS_1";
    const DB_ERROR_MSG = "数据库异常";

    const CACHE_ERROR = "SYS_2";
    const CACHE_ERROR_MSG = "缓存异常";

    const HTTP_ERROR = "SYS_3";
    const HTTP_ERROR_MSG = "调用HTTP接口发生异常";

    const RETURN_NULL_ERROR = "SYS_4";
    const RETURN_NULL_ERROR_MSG = "服务不能返回空对象";

    const SERVER_UNAVAILABLE_ERROR = "SYS_5";
    const SERVER_UNAVAILABLE_ERROR_MSG = "服务端不可用";

    const SERVER_ADDR_NOT_FOUND = "SYS_6";
    const SERVER_ADDR_NOT_FOUND_MSG = "服务地址未找到";

    const NO_MICRO_SERVICE_CLASS = "SYS_7";
    const NO_MICRO_SERVICE_CLASS_MSG = "非微服务客户端类";

    public static function isError(string $code): bool
    {
        return ErrorCode::UNKNOWN_ERROR === $code ||
            (!empty($code) && self::startWith($code, self::ERROR_PREFIX));
    }

    private static function startWith($str, $needle): bool
    {
        return strpos($str, $needle) === 0;
    }

    /**
     * 用于抛出ServiceErrorException
     *
     * @param string $code
     * @param string $msg
     * @param Throwable|null $cause
     * @return ServiceErrorException
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/2/29 11:40
     */
    public static function error(
        string $code,
        string $msg,
        Throwable $cause = null
    ): ServiceErrorException {
        return new ServiceErrorException($msg, $code, $cause);
    }
}