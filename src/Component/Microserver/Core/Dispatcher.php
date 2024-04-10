<?php
namespace YoLaile\Library\Component\Microserver\Core;

use YoLaile\Library\Component\Microserver\Core\Exception\DispatcherException;

class Dispatcher
{
    /** @var array 服务调度信息 数组结构 */
    public static $convention;

    /**
     * 获取服务的访问地址
     *
     * @param string $serviceName
     * @param string $actionName
     * @return Convention
     * @throws DispatcherException
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/3 14:06
     */
    public static function getConvention(string $serviceName, string $actionName): Convention
    {
        if (empty($serviceName) || empty($actionName)) {
            throw new DispatcherException('获取规约参数不全');
        }

        //获取该服务的约定配置信息 [某一个服务的信息]
        empty(self::$convention[$serviceName]) && self::$convention[$serviceName] = self::getConventionInfo($serviceName);
        if (empty(self::$convention[$serviceName])) {
            throw new DispatcherException("当前服务{$serviceName}不存在约定信息");
        }

        //获取当前调用模块的调度信息 [某一服务下特定路由的信息]
        $dispatcherInfo       = self::getActionInfo(self::$convention[$serviceName], $actionName);
        //开发特殊处理逻辑 TODO

        //组装规约信息
        list('scheme' => $scheme, 'host' => $host, 'port' => $port, 'uri' => $uri, 'method' => $method, 'params' => $params, 'version' => $version) = $dispatcherInfo;


        return new Convention(
            $scheme,
            $host,
            $port,
            $uri,
            $method,
            $params,
            $version,
            $dispatcherInfo['sign'] ?? '',
            $serviceName,
            $actionName
        );
    }

    /**
     * getActionInfo 处理具体的某一个服务的某一个路由的信息
     *
     * @param array $convention
     * @param string $actionName
     * @return array
     * @throws DispatcherException
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 19:47
     */
    private static function getActionInfo(array $convention, string $actionName): array
    {
        if (empty($convention[$actionName]) || empty($convention['serviceInfo'])) {
            throw new DispatcherException('调度信息配置文件路由信息缺失');
        }

        // 拼装调度信息
        $actionInfo['scheme']       = $convention['serviceInfo']['scheme'] ?? '';
        $actionInfo['host']         = $convention['serviceInfo']['host'] ?? '';
        $actionInfo['sign']         = $convention['serviceInfo']['sign'] ?? '';
        $actionInfo['port']         = (int) $convention['serviceInfo']['port'] ?? '80';
        $actionInfo['uri']          = $convention[$actionName]['uri'] ?? '';
        $actionInfo['method']       = $convention[$actionName]['method'] ?? '';
        $actionInfo['version']      = $convention[$actionName]['version'] ?? '';
        $actionInfo['params']       = $convention[$actionName]['params'] ?? '';

        return $actionInfo;
    }

    private static function getConventionInfo(string $serviceName): array
    {
        $conventionFilePath = dirname(__DIR__) . DIRECTORY_SEPARATOR . 'Config' . DIRECTORY_SEPARATOR . lcfirst($serviceName) . '.ini';

        if (! file_exists($conventionFilePath)) {
            throw new DispatcherException('调度异常,调度配置文件不存在');
        }
        $convention = parse_ini_file($conventionFilePath, true);

        if (empty($convention)) {
            throw new DispatcherException('调度配置文件解析失败');
        }

        return $convention;
    }
}