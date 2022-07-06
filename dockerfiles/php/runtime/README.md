# php_runtime

PHP运行时基础镜像编排

## 环境

此环境为常规的 `LNP` 基础服务环境,服务列表与组件列表涵盖如下
 
- [x] `fpm` 

- [x] `cron`

- [x] `supervisor`

- [x] `nginx`

- [x] `composer`

- [x] `php.redis`

## 规则

#### 程序目录

`/var/www/app`

#### 暴露端口

- 80

- 443

#### 用户启动

`www`
