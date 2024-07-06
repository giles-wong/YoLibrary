<?php

namespace YoLaile\Library\Convention\Domain;

/**
 * 轻量化分页接口
 *
 * @package App\Component\Convention\Domain
 *
 * @author  Giles <giles.wang@aliyun.com|giles.wang@qq.com>
 * @date    2024/7/5 17:04
 */
interface LitePage
{
    /**
     * 获取页号
     * @return int 页号
     */
    function getPageNumber(): int;

    /**
     * 获取每页可显示的记录数
     * @return int 每页可显示的记录数
     */
    function getPageSize(): int;

    /**
     * 获取数据列表
     * @return array 数据列表
     */
    function getResults(): array;

    /**
     * 是否有下一页
     * @return bool
     */
    function hasNext(): bool;
}
