## 一、安装编译工具及库文件

**首先需要安装各种必须工具：**

* gcc
* gcc-c++
* autoconf
* automake

```bash
yum -y install gcc gcc-c++ autoconf automake
```

安装一些专用的库：

* 支持gzip功能的：zlib库

* rewrite模块：pcre库

* ssl功能：openssl库

```bash
yum -y install zlib zlib-devel pcre pcre-devel openssl openssl-devel
```

## 二、安装Nginx

下载nginx：

```bash
wget http://nginx.org/download/nginx-1.12.2.tar.gz
```

解压安装包：
```bash
tar zxvf nginx-1.12.2.tar.gz
```

进入安装包目录:
```bash
cd nginx-1.12.2
```

编译安装:
```bash
./configure --with-http_stub_status_module --with-http_ssl_module
```

```
注释：
开启ssl模块 --with-http_ssl_module
启用“server+status"页，--with-http_stub_status_module
```

```bash
make && make install
```

查看版本号：
```bash
/usr/local/nginx/sbin/nginx -v
```

测试是否安装成功：
```bash
/usr/local/nginx/sbin/nginx -t
 
nginx: the configuration file /usr/local/nginx/conf/nginx.conf syntax is ok
nginx: configuration file /usr/local/nginx/conf/nginx.conf test is successful
```

下来配置环境变量
```bash
export NGINX_HOME=/usr/local/nginx
export PATH=$PATH:$NGINX_HOME/sbin
```
>使用export设置环境变量之后，重启机器会失效，因此写入/etc/profile。

```bash
echo "alias nginx='/home/web/nginx/sbin/nginx'" >> /etc/profile
```
保存，执行 source /etc/profile ，使配置文件生效。执行nginx -v,就能看到版本了，说明nginx 安装成功了。

Nginx 常用的几个命令

* nginx -s reload            # 重新载入配置文件
* nginx -s reopen            # 重启 Nginx
* nginx -s stop              # 停止 Nginx