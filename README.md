# 介绍

PHP Code Library 收集整理常用的php工具类库

# Install
1. 方式一
```metadata json
   composer require yolaile/library
```

2. 方式二
   Step1: 在项目composer.json文件require段中增加如下：
```metadata json
{
    "require": {
        "yolaile/library": "^0.3"
    }
}
```
Step2: 执行 ``` composer update yolaile/library```

# Document

## Component

### 1. Log
日志组件库，提供日志写入功能
- `(2024-03-20)` Log:[Log, 各项目内日志记录](document/Component/Log.md)
### 2. Signature
api 接口签名验证
- `(2024-04-01)` Signature:[Signature, api 接口签名](document/Component/Signature.md)

## IdCard.php
> 用于校验中国大陆居民身份证号码合法性，获取对应的信息，如地区、性别、生日、星座、属相等,身份证代码计算方式为GB 11643-1999标准
, 兼容地区编码变更以前的数据

```php
use YoLaile\Library\IdCard;

$idCard = new IdCard();
//验证身份证合法性，合法返回相应的所属信息，不合法返回false
$idcard->verification('210203197503102721');
//随机生成一个身份证号
$idcard->generate();
```
## Snowflake.php

> 基于Twitter的雪花算法改造，分布式全局唯一ID生成器, 组成<毫秒级时间戳+机器ip+进程id+序列号>

 长度最长为64位bit,各bit位含义如下：
-  `1位` 不用。二进制中最高位为1的都是负数，但是我们生成的id一般都使用整数，所以这个最高位固定是0
-  `41位` 用来记录时间戳（毫秒）
    - 41位可以表示$2^{41}-1$个数字，
    - 如果只用来表示正整数（计算机中正数包含0），可以表示的数值范围是：0 至 $2^{41}-1$，减1是因为可表示的数值范围是从0开始算的，而不是1。
    - 也就是说41位可以表示$2^{41}-1$个毫秒的值，转化成单位年则是$(2^{41}-1) / (1000 * 60 * 60 * 24 * 365) = 69$年
-  `10位` 机器IP低10位,可以支持最多1023个机器节点
-  `10位` 当前处理进程标识,10位的长度最多支持1023个机器进程
-  `2位`  计数序列号,序列号即序列自增id,可以支持同一节点的同一进程同一毫秒生成4个ID序号 

```php
use yolaile\Library\Snowflake;

//生成一个全局唯一ID
echo Snowflake::uniqueId();
```
