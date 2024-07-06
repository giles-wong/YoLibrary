<?php

namespace YoLaile\Library\Convention\Code;

use Throwable;
use YoLaile\Library\Convention\Exception\ServiceErrorException;

/**
 *
 * 错误码常量
 *
 * @package YoLaile\Library\Convention\Code
 *
 * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
 * @date 2024/7/5 16:57
 */
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
            (!empty($code) && self::startWith($code));
    }

    private static function startWith($str): bool
    {
        return str_starts_with($str, self::ERROR_PREFIX);
    }

    /**
     * 用于抛出ServiceErrorException
     * @param string $code
     * @param string $msg
     * @param Throwable|null $cause
     * @return ServiceErrorException
     */
    public static function error(string $code, string $msg, Throwable $cause = null): ServiceErrorException
    {
        return new ServiceErrorException($msg, $code, $cause);
    }
}
