<?php

namespace YoLaile\Library\Convention\Exception;

use YoLaile\Library\Convention\Code\ErrorCode;

/**
 *
 * Class ServiceErrorException
 *
 * @package YoLaile\Library\Convention\Exception
 *
 * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
 * @date 2024/7/5 16:55
 */
class ServiceErrorException extends ServiceException
{
    protected $errorCode;

    public function __construct(
        string $message = ErrorCode::UNKNOWN_ERROR_MSG,
        string $errorCode = ErrorCode::UNKNOWN_ERROR,
        \Throwable $previous = null
    ) {
        parent::__construct($message, 101, $previous);
        $this->errorCode = $errorCode;
    }
}
