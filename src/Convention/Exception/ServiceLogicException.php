<?php

namespace YoLaile\Library\Convention\Exception;

/**
 *
 * Class ServiceLogicException 业务逻辑异常类
 *
 * @package YoLaile\Library\Convention\Exception
 *
 * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
 * @date 2024/7/5 16:56
 */
class ServiceLogicException extends ServiceException
{
    public function __construct(
        string $message,
        string $errorCode,
        \Throwable $previous = null
    ) {
        parent::__construct($message, 103, $previous);
        $this->errorCode = $errorCode;
    }
}
