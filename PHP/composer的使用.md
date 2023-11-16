## 安装

### Linxu下全局安装composer

下载composer
```
curl -sS https://getcomposer.org/installer | php
```

将composer.phar文件移动到bin目录以便全局使用composer命令
```
mv composer.phar /usr/local/bin/composer
```

切换阿里云Composer全量镜像
```
composer config -g repo.packagist composer https://mirrors.aliyun.com/composer/
```

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

## 版本号

| 名称 | 实例 | 描述 |
| :---: | :---: | :---: |
| 确切的版本号 | 1.0.2 | 指定包的确切版本 |
| 范围 | >=1.0<br>>=1.0,<2.0<br>>=1.0,<1.1&#124;>=1.2 | 通过使用比较操作符可以指定有效的版本范围。有效的运算符：>、>=、<、<=、!=。 你可以定义多个范围，用逗号隔开，这将被视为一个逻辑AND处理。一个管道符号 &#124; 将作为逻辑OR处理。 AND的优先级高于OR。|
| 通配符 | 1.0.* | 通配符*来指定一种模式。1.0.*与>=1.0,<1.1是等效的。 |
| 赋值运算符 | ~1.2 | ~1.2相当于>=1.2,<2.0 |


~和^的意思很接近，在x.y的情况下是一样的都是代表x.y <= 版本号 < (x+1).0，但是在版本号是x.y.z的情况下有区别，举个例子吧：

~1.2.3 代表 1.2.3 <= 版本号 < 1.3.0

^1.2.3 代表 1.2.3 <= 版本号 < 2.0.0