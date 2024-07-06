<?php

namespace YoLaile\Library\Convention\Domain;

class DefaultResult implements Result
{
    public $code;
    public $message;
    public $data;

    public function __construct($message, $code, $data = null)
    {
        $this->message = $message;
        $this->code = $code;
        $this->data = $data;
    }

    /**
     * 获取错误码
     * @return string 错误码
     */
    public function getCode(): string
    {
        return $this->code;
    }

    /**
     * 获取成功或错误的信息
     * @return string 成功或错误的信息
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * 获取数据
     * @return object 数据
     */
    public function getData(): object
    {
        return $this->data;
    }

    /**
     * 获取校验失败的字段
     * @return array 校验失败的字段
     */
    public function getViolationItems(): array
    {
        return [];
    }

    /**
     * 设置错误码
     * @param string $code 错误码
     * @return Result Result对象
     */
    public function setCode(string $code): Result
    {
        $this->code = $code;
        return $this;
    }

    /**
     * 设置成功或错误的信息
     * @param string $message 成功或错误的信息
     * @return Result
     */
    public function setMessage(string $message): Result
    {
        $this->message = $message;
        return $this;
    }

    /**
     * 设置数据
     * @param object $data 数据
     * @return Result
     */
    public function setData(object $data): Result
    {
        $this->data = $data;
        return $this;
    }

    /**
     * 设置验证失败的字段
     * @param ViolationItem[] $violationItems 验证失败的字段
     */
    public function setViolationItems(array $violationItems)
    {
    }

    /**
     * 添加 ViolationItem
     * @param string $field ViolationItem 的 field
     * @param string $message ViolationItem 的 message
     * @return Result
     */
    public function addViolationItem(string $field, string $message): Result
    {
        return $this;
    }

    /**
     * 是否成功
     * @return bool
     */
    public function isSuccess(): bool
    {
        return (SuccessCode::SUCCESS === $this->code);
    }

    /**
     * 是否错误
     * @return bool
     */
    public function isError(): bool
    {
        return ErrorCode::isError($this->code);
    }

    /**
     * 是否是业务处理失败，业务异常
     * @return bool
     */
    public function isFailure(): bool
    {
        return (!$this->isSuccess()) && (!$this->isError());
    }

    /**
     * 有无校验失败的项目
     * @return bool true表示存在校验失败的项目
     */
    public function hasViolationItems(): bool
    {
        return false;
    }

    /**
     * 如果isError()为true，抛出ServiceErrorException
     * 如果isFailure()为true，抛出ServiceLogicException
     * @return mixed
     * @throws ServiceErrorException, ServiceLogicException
     */
    public function checkAndGetData(): mixed
    {
        if ($this->isError()) {
            throw new ServiceErrorException($this->getMessage(), $this->getCode());
        } elseif ($this->isFailure()) {
            throw new ServiceLogicException($this->getMessage(), $this->getCode());
        }
        return $this->getData();
    }

    function __toString()
    {
        return json_encode($this, JSON_UNESCAPED_UNICODE);
    }

    function jsonSerialize()
    {
        return $this;
    }
}
