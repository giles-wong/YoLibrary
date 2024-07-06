<?php

namespace YoLaile\Library\Convention\Domain;

class Pages
{
    /** @var int 默认每页显示的记录数 */
    const DEFAULT_PAGE_SIZE = 20;

    /** @var int 单页最多显示的记录数 */
    const MAX_PAGE_SIZE = 200;

    public static function page(array $results, int $totalCount, int $pageNumber = 1,
        int $pageSize = Pages::DEFAULT_PAGE_SIZE): Page
    {
        return new DefaultPage($results, $totalCount, $pageNumber, $pageSize);
    }

    /**
     * 翻页静态创建方法
     *
     * @param array $results
     * @param bool $hasNext
     * @param int $pageNumber
     * @param int $pageSize
     * @return DefaultLitePage
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/7/5 17:17
     */
    public static function litePage(array $results, bool $hasNext, int $pageNumber = 1,
        int $pageSize = Pages::DEFAULT_PAGE_SIZE): LitePage
    {
        return new DefaultLitePage($results, $hasNext, $pageNumber, $pageSize);
    }

    /**
     * 游标翻页静态创建方法
     * 只有下一页，没有最终页
     *
     * @param string|int $pageCursor 当前页的游标
     * @param int $pageSize 每页显示的记录数
     * @param bool $hasNext 有无下一页
     * @param string|int|null $nextCursor 下一页的游标
     * @param array $results 数据列表
     *
     * @return CursorPage
     */
    public static function cursorPage(array $results, bool $hasNext, $nextCursor, $pageCursor,
        int $pageSize = Pages::DEFAULT_PAGE_SIZE)
    {
        return new DefaultCursorPage($results,
            $hasNext,
            $nextCursor,
            $pageCursor,
            $pageSize);
    }
}
