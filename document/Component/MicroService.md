***[Return Index](../../README.md)***

MicroService
=====================
MicroService 服务调用组件

## Usage
- 定义服务配置文件  `yoShop.ini`
  - 主要包含 serviceInfo 内需要有协议、host 端口 签名方式信息
  - getUrl 方法名 包含接口地址 请求方式  请求参数类型
```ini
[serviceInfo]
; 服务相关信息
scheme = http
host = giles-saas.yolaile.com
port = 80
sign = 1234

[getUrl]
; 获取随访时间和下次随访时间规则
params = noData
uri = yshop/get-url
method = get
version = 0.0.1
```

```
    MicroService::yoShop()->getUrl(['aa' => 'bb']);
```

***[Return Index](../../README.md)***