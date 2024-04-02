<?php
namespace YoLaile\Library\Component\Log;

/**
 *
 * Class LogChannel
 * @package YoLaile\Library\Component\Log
 *
 * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
 * @date 2024/3/27 10:47
 */
class LogChannel
{
    protected const PHP_LOGIC_EXCEPTION = 'php.logic.exception';
    protected const PHP_ERROR_EXCEPTION = 'php.error.exception';
    protected const PHP_REQUEST_PARAMS  = 'php.request.params';

    protected const PHP_RESPONSE_PARAMS  = 'php.response.params';
    protected const PHP_BUSINESS_LOGIC  = 'php.business.logic';
    protected const PHP_DEBUG           = 'php.debug';
    protected const PHP_DOT             = 'php.application';
    protected const PHP_EXECUTE_SQL     = 'php.execute.sql';

    /**
     * support 支持的Channel
     *
     * @return string[]
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date   2020/8/4 16:09
     */
    public static function support():string
    {
        return [
            self::PHP_ERROR_EXCEPTION,
            self::PHP_LOGIC_EXCEPTION,
            self::PHP_REQUEST_PARAMS,
            self::PHP_RESPONSE_PARAMS,
            self::PHP_BUSINESS_LOGIC,
            self::PHP_DEBUG,
            self::PHP_DOT,
            self::PHP_EXECUTE_SQL
        ];
    }

    /**
     * default 默认日志 通道名称
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date   2020/8/4 16:17
     */
    public static function default():string
    {
        return self::PHP_DOT;
    }

    /**
     * logicException 逻辑异常 通道名称
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date   2020/8/4 16:11
     */
    public static function phpLogicException():string
    {
        return self::PHP_LOGIC_EXCEPTION;
    }

    /**
     * errorException 错误异常日志 通道名称
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date   2020/8/4 16:11
     */
    public static function phpErrorException():string
    {
        return self::PHP_ERROR_EXCEPTION;
    }

    /**
     * requestParams 请求参数日志 通道名称
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date   2020/8/4 16:11
     */
    public static function requestParams():string
    {
        return self::PHP_REQUEST_PARAMS;
    }

    /**
     * responseParams 返回参数日志 通道名称
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/2 09:48
     */
    public static function responseParams():string
    {
        return self::PHP_RESPONSE_PARAMS;
    }

    /**
     * businessLogic 业务逻辑日志 通道名称
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date   2020/8/4 16:11
     */
    public static function businessLogic():string
    {
        return self::PHP_BUSINESS_LOGIC;
    }

    /**
     * debug 调试日志 通道名称
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date   2020/8/4 16:11
     */
    public static function debug():string
    {
        return self::PHP_DEBUG;
    }

    /**
     * dot 打点日志 通道名称
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date   2020/8/4 16:11
     */
    public static function dot():string
    {
        return self::PHP_DOT;
    }

    /**
     * executeSql 执行sql日志 通道名称
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date   2020/8/4 16:11
     */
    public static function executeSql():string
    {
        return self::PHP_EXECUTE_SQL;
    }
}