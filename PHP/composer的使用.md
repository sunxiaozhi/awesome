## 安装

## 命令行

### 配置阿里云镜像

* 全局配置

```
composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/
```

* 单独使用

```
composer config repo.packagist composer https://mirrors.aliyun.com/composer/
```

* 取消镜像

```
composer config -g --unset repos.packagist
```

## composer.json架构

## Composer 多线程下载加速（全局安装）

```
composer global require hirak/prestissimo
```