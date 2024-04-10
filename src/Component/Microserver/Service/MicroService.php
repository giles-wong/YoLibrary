<?php
namespace YoLaile\Library\Component\Microserver\Service;

use Psr\Log\LoggerInterface;
use Psr\Log\NullLogger;
use YoLaile\Library\Component\Microserver\Manager\BaseManager;

class MicroService
{
    /** @var LoggerInterface|NullLogger  */
    private $logger = null;

    /** @var array|string[]  */
    private $headers = [];

    /** @var MicroService  */
    protected static $instance;

    /**
     * __construct
     *
     * @param array $headers
     * @param LoggerInterface|null $logger
     */
    public function __construct(array $headers = ["api-style" => "1"], LoggerInterface $logger = null)
    {
        $this->logger    = $logger ?? new NullLogger();
        $this->headers   = $headers;

        self::$instance  = $this;
    }

    /**
     * callStatic
     *
     * @param $name
     * @param $arguments
     * @return BaseManager
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 19:16
     */
    public static function __callStatic($name, $arguments)
    {
        return new BaseManager(
            $name,
            self::getInstance()->getHeaders(),
            self::getInstance()->getLogger()
        );
    }

    /**
     * 获取 header 头信息
     *
     * @return array|string[]
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 19:15
     */
    private function getHeaders():array
    {
        return $this->headers;
    }

    public function __call(string $functionName, array $args)
    {
        dd(123456);
    }

    /**
     * getInstance
     *
     * @return MicroService
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 19:17
     */
    private static function getInstance(): MicroService
    {
        if (null === self::$instance) {
            self::$instance = new self;
        }

        return self::$instance;
    }

    /**
     * 获取日志处理器
     *
     * @return LoggerInterface
     * @author Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date 2024/4/9 19:15
     */
    private function getLogger():LoggerInterface
    {
        return $this->logger;
    }
}