## 安装所需依赖包

## 下载php7.4

## 新增用户组，用户，用于编译使用

```
groupadd www 

useradd -g www www
```

## 安装libzip(php7.4需要libzip >= 0.11，yum源的lizib为0.10，所以需要编译安装
```
yum remove libzip libzip-devel
wget https://hqidi.com/big/libzip-1.2.0.tar.gz
tar -zxvf libzip-1.2.0.tar.gz
cd libzip-1.2.0
./configure
make && make install
```

## 指定PKG_CONFIG_PATH
```
export PKG_CONFIG_PATH="/usr/local/lib/pkgconfig/"
```

## 编译安装（./configure --help 查看编译参数）

