<?php
namespace YoLaile\Library\Component\Microserver\Core\Exception;

class ResponseException extends Exception
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
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/10 09:31
     */
    public function getErrorCode(): string
    {
        return $this->errorCode;
    }
}