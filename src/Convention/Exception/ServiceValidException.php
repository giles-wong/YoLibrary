<?php

namespace YoLaile\Library\Convention\Exception;

/**
 *
 * Class ServiceValidException 验证参数异常类
 *
 * @package YoLaile\Library\Convention\Exception
 *
 * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
 * @date 2024/7/5 16:56
 */
class ServiceValidException extends ServiceLogicException
{

    protected $errorCode;
    private   $violationItems;

    public function __construct(
        string $message = CommonCode::INVALID_ARGS_MSG,
        string $errorCode = CommonCode::INVALID_ARGS,
        array $violationItems = []
    ) {
        parent::__construct($message, 102);
        $this->violationItems = $violationItems;
        $this->errorCode      = $errorCode;
    }

    public function getViolationItems(): array
    {
        return $this->violationItems;
    }
}
