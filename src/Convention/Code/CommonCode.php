<?php
namespace YoLaile\Library\Convention\Code;

/**
 *
 * 公共业务异常码
 * @package YoLaile\Library\Convention\Code
 *
 * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
 * @date 2024/2/29 11:35
 */
class CommonCode
{
    const INVALID_ARGS = "C_1";
    const INVALID_ARGS_MSG = "参数无效";

    const DATA_NOT_FOUND = "C_2";
    const DATA_NOT_FOUND_MSG = "当前数据不存在";

    const NO_LOGIN = "C_3";
    const NO_LOGIN_MSG = "用户未登录";

    const INVALID_AUTH = "C_4";
    const INVALID_AUTH_MSG = "权限无效";

    const RECORD_EXISTED = "C_5";
    const RECORD_EXISTED_MSG = "已经存在该记录";

    const ILLEGAL_STATE = "C_6";
    const ILLEGAL_STATE_MSG = "无效的状态";

    const METHOD_NOT_ALLOWED = "C_7";
    const METHOD_NOT_ALLOWED_MSG = "不支持的请求方法";

    const URL_NOT_FOUND = "C_8";
    const URL_NOT_FOUND_MSG = "无效的访问地址";

    const ILLEGAL_REQUEST = "C_9";
    const ILLEGAL_REQUEST_MSG = "非法的请求";
}