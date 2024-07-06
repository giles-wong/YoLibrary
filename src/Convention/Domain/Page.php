<?php

namespace YoLaile\Library\Convention\Domain;

/**
 * DefaultPage
 * @package YoLaile\Library\Convention\Domain
 *
 * @author  Giles <giles.wang@aliyun.com|giles.wang@qq.com>
 * @date    2024/7/5 16:48
 */
interface Page
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
     * 获取总记录数
     * @return int 总记录数
     */
    function getTotalCount(): int;

    /**
     * 获取数据列表
     * @return array 数据列表
     */
    function getResults(): array;

    /**
     * 获取总页数
     * @return int 总页数
     */
    function getTotalPages(): int;

}
