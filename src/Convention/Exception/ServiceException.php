<?php
namespace YoLaile\Library\Convention\Exception;

use RuntimeException;

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
     * 获取下游服务的异常码
     *
     * @return string
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/2/29 11:38
     */
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }
}