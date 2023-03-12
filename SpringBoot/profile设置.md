# 配置方式
## 命令行方式
命令行方式是一种外部配置的方式，在执行java -jar命令时可以通过 --spring.profiles.active=test的方式进行激活指定的profiles列表。

使用方式如下所示：

```shell script
java -jar order-service-v1.0.jar --spring.profiles.active=dev
```

## 系统变量方式
需要添加一个名为SPRING_PROFILES_ACTIVE的环境变量。

linux环境下可以编辑环境变量配置文件/etc/profile，添加下面的一行：

* spring 环境配置
```shell script
export SPRING_PROFILES_ACTIVE=dev
```

windows如何配置可自行百度。

这种方式在docker之类的环境下很有用，一次编译，环境自由切换

## Java系统属性方式

Java系统属性方式也是一种外部配置的方式，在执行java -jar命令时可以通过-Dspring.profiles.active=test的方式选择指定的profiles。

使用方式如下所示：

```shell script
java -Dspring.profiles.active=dev -jar order-service-v1.0.jar

注意：-D 方式设置Java系统属性要在-jar前定义。
```

## 配置文件方式
配置文件方式是最常用的方式。我们只需要在application.yml配置文件添加配置即可，使用方式如下所示：

```shell script
spring:
  profiles:
    # 选择的profiles
    active: dev
```

优先级

优先级大致如下：

```
命令行方式 > Java系统属性方式 > 系统变量方式 > 配置文件方式
```

经过测试命令行方式的优先级最高，而内部配置文件方式则是最低的。

## 激活多个profile

如果需要激活多个profile可以使用逗号隔开，如：

```shell script
--spring.profiles.active=dev,test
```

