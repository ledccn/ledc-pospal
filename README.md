# Pospal银豹收银系统开放平台非官方SDK

## 安装
`composer require ledc/pospal`

## 使用

开箱即用，只需要传入一个配置，初始化一个实例即可：

```php
use Ledc\Pospal\Certificate;
use Ledc\Pospal\CustomerApi;

$config = [
    'appId' => '银豹appId',
    'appKey' => '银豹appKey',
    'urlPrefix' => '银豹接口地址前缀',
];
$certificate = new Certificate($config);
$customerApi = new CustomerApi($certificate);
```

在创建实例后，所有的方法都可以有IDE自动补全；例如：

```php
//添加会员
$customerApi->add();
//根据会员号查询会员
$customerApi->queryByNumber();
//根据会员手机号查询会员
$customerApi->queryByTel();
//根据会员在银豹系统的唯一标识查询
$customerApi->queryByUid();
//修改会员密码
$customerApi->updatePassword();
//修改会员余额积分
$customerApi->updateBalancePointByUid();
```

## 二次开发

配置与凭证类：`Ledc\Pospal\Certificate`
银豹请求客户端：`Ledc\Pospal\HttpClient`
银豹响应类：`Ledc\Pospal\HttpResponse`

你可以继承`Ledc\Pospal\Certificate`或`Ledc\Pospal\HttpClient`，扩展您需要的功能。

## 捐赠

![reward](reward.png)

## 官方文档
https://pospal.cn/openplatform/openplatform.html