<?php
namespace YoLaile\Library\Component\Microserver\Manager;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use YoLaile\Library\Component\Microserver\Core\Dispatcher;
use YoLaile\Library\Component\Microserver\Core\Exception\DispatcherException;
use YoLaile\Library\Component\Microserver\Request\Request;
use YoLaile\Library\Component\Microserver\Request\RequestMetaData;
use YoLaile\Library\Convention\Exception\ServiceErrorException;

class BaseManager
{
    private $serviceName = '';

    private $logger = null;

    private $headers;

    public function __construct(string $serviceName, array $headers = ["api-style" => "1"], LoggerInterface $logger = null) {
        $this->serviceName = $serviceName;
        $this->logger    = $logger ?? new NullLogger();
        $this->headers   = $headers;
    }

    /**
     * __call 通过魔术方法，获取调用的是哪个服务的哪个路由
     *
     * @param string $functionName
     * @param array $args
     * @return mixed
     * @throws DispatcherException
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/3 14:03
     */
    public function __call(string $functionName, array $args)
    {
        return $this->send($functionName, $args);
    }

    /**
     * @throws DispatcherException
     */
    private function send(string $functionName, array $args)
    {
        if (empty($this->serviceName)) {
            throw new ServiceErrorException('服务名称不能为空!');
        }
        if (empty($functionName)) {
            throw new ServiceErrorException('服务方法不能为空!');
        }

        // 获取注册信息，并给客户端需要处理的属性赋值
        $convention = Dispatcher::getConvention($this->serviceName, $functionName);
        // 根据规约和参数，拼装请求数据
        $requestMetaData = new RequestMetaData($convention, $args, $this->headers);

        // 发送请求
        return (new Request($this->getHeaders(), $this->getLogger()))->send($requestMetaData);
    }

    public function getLogger()
    {
        return $this->logger;
    }
    
    public function getHeaders():array
    {
        return $this->headers;
    }
}