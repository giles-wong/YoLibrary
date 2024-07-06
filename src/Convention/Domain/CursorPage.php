<?php

namespace YoLaile\Library\Convention\Domain;

interface CursorPage
{
    /**
     * 当前页的游标
     * @return mixed
     */
    public function getPageCursor(): mixed;

    /**
     * 获取每页可显示的记录数
     * @return int
     */
    public function getPageSize(): int;

    /**
     * 下一页的游标
     * @return mixed
     */
    public function getNextCursor():mixed;

    /**
     * 是否存在下一页
     * @return bool
     */
    public function hasNext(): bool;

    /**
     * 获取数据列表
     * @return mixed
     */
    public function getResults():mixed;
}
