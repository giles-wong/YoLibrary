<?php

namespace YoLaile\Library\Convention\Domain;

use YoLaile\Library\Convention\Exception\ServiceValidException;

/**
 *
 * 默认的轻量翻页实现
 *
 * @package YoLaile\Library\Convention\Domain
 *
 * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
 * @date 2024/7/5 17:05
 */
class DefaultLitePage implements LitePage
{
    /** @var int 第几页 */
    public int $pageNumber;

    /** @var int 每页显示多少条记录数 */
    public int $pageSize;

    /** @var bool  */
    public bool $hasNext;

    /** @var array 结果集 */
    public array $results;

    function __construct(array $results, bool $hasNext, int $pageNumber = 1, int $pageSize = 10)
    {
        if ($pageNumber < 1) {
            throw new ServiceValidException("当前页不能小于1");
        }
        if ($pageSize < 1) {
            throw new ServiceValidException("单页记录不能小于1");
        }

        $this->pageNumber = $pageNumber;
        $this->pageSize = $pageSize;
        $this->results = $results ?? [];
        $this->hasNext = $hasNext;
    }

    /**
     * 获取页号
     * @return int 页号
     */
    function getPageNumber(): int
    {
        return $this->pageNumber;
    }

    /**
     * 获取每页可显示的记录数
     * @return int 每页可显示的记录数
     */
    function getPageSize(): int
    {
        return $this->pageSize;
    }

    /**
     * 获取数据列表
     * @return array 数据列表
     */
    function getResults(): array
    {
        return $this->results;
    }

    /**
     * 是否有下一页
     * @return bool
     */
    function hasNext(): bool
    {
        return $this->hasNext;
    }
}
