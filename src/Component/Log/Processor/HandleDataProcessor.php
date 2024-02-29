<?php
namespace YoLaile\Library\Component\Log\Processor;

use YoLaile\Library\Component\Log\Config;
use Monolog\Processor\ProcessorInterface;

class HandleDataProcessor implements ProcessorInterface
{
    /**
     * @param array $record
     *
     * @return array
     * @author  Giles <giles.wang@aliyun.com|giles.wang@qq.com>
     * @date    2019/11/29 17:31
     */
    public function __invoke(array $record): array
    {
        foreach ($record as $key => $item) {
            //时间格式化
            if ($item instanceof \DateTime || $item instanceof \Monolog\DateTimeImmutable) {
                $record[$key] = $item->format('Y-m-d H:i:s.u');
            }
        }
        //json 格式日志排序
        if (strcasecmp(Config::get('format'), 'json') === 0) {
            $jsonFormat = [];
            foreach (Config::getFormat() as $value) {
                isset($record[$value]) &&  $jsonFormat[$value] = $record[$value];
            }
            return $jsonFormat;
        }

        return $record;
    }
}