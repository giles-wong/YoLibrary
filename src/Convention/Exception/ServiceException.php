<?php

namespace YoLaile\Library\Convention\Exception;

use RuntimeException;

/**
 *
 * Class ServiceException 服务调用异常
 *
 * @package YoLaile\Library\Convention\Exception
 *
 * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
 * @date 2024/7/5 16:55
 */
class ServiceException extends RuntimeException
{
    protected $errorCode;

    public function __construct(
        string $message,
        string $errorCode,
        \Throwable $previous = null
    ) {
        parent::__construct($message, 100, $previous);
        $this->errorCode = $errorCode;
    }

    /**
     * getErrorCode 获取下游服务的异常码
     *
     * @return string
     *
     * @author JadeSouth <jadesouth@aliyun.com>
     * @author HuWei <huwei@huwei.com>
     * @date   2018-11-08 16:55:12
     */
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }
}
