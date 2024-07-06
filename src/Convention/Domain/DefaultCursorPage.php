<?php

namespace YoLaile\Library\Convention\Domain;


use YoLaile\Library\Convention\Exception\ServiceValidException;

class DefaultCursorPage implements CursorPage
{
    /**
     * 当前页面对应的游标
     */
    public $pageCursor;
    public $pageSize;
    /**
     * 下一页对应的游标
     */
    public $nextCursor;
    public $hasNext;
    /**
     * 查询结果集合
     */
    public $results;

    public function __construct(array $results, bool $hasNext, $nextCursor, $pageCursor,
        int $pageSize = Pages::DEFAULT_PAGE_SIZE)
    {
        if ($pageSize < 1) {
            throw new ServiceValidException("页记录数不能小于1");
        }

        if ($pageCursor < 0) {
            throw new ServiceValidException("页游标不能小于0");
        }

        $this->pageCursor = $pageCursor;
        $this->pageSize   = $pageSize;
        $this->results    = $results ?? [];
        $this->hasNext    = $hasNext;
        $this->nextCursor = $nextCursor;
    }

    /**
     *
     * @return int|string
     */
    function getPageCursor(): int|string
    {
        return $this->pageCursor;
    }

    function getPageSize(): int
    {
        return $this->pageSize;
    }

    function getNextCursor(): int|string
    {
        return $this->nextCursor;
    }

    function hasNext(): bool
    {
        return $this->hasNext;
    }

    function getResults(): array
    {
        return $this->results;
    }
}
