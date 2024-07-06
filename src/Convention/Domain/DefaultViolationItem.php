<?php

namespace YoLaile\Library\Convention\Domain;

class DefaultViolationItem implements ViolationItem
{

    /**
     * @var string
     */
    public $field;
    /**
     * @var string
     */
    public $message;

    public function __construct($field, $message)
    {
        $this->message = $message;
        $this->field = $field;
    }

    /**
     * 获取验证失败的字段名
     * @return string 验证失败的字段名
     */
    public function getField(): string
    {
        return $this->field;
    }

    /**
     * 设置验证失败的字段名
     * @param string $field 验证失败的字段名
     */
    public function setField(string $field): void
    {
        $this->field = $field;
    }

    /**
     * 获取验证失败的信息
     * @return string 验证失败的信息
     */
    public function getMessage(): string
    {
        return $this->message;
    }

    /**
     * 设置验证失败的信息
     * @param string $message 验证失败的信息
     */
    public function setMessage(string $message)
    {
        $this->message = $message;
    }
}
