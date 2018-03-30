先进行最简单的安装

安装一些专用的库：
```bash
yum -y install libxml2-devel
```

下载php安装包
```bash
wget http://cn2.php.net/get/php-7.2.4.tar.gz/from/this/mirror -O php-7.2.4.tar.gz
```

解压安装包
```bash
tar zxvf php-7.2.4.tar.gz
```

进入安装包
```bash
cd php-7.2.4
```

编译php
```bash
./configure --prefix=/usr/local/php --with-config-file-path=/usr/local/php/etc --enable-fpm
```

安装php
```bash
make && make install
```

配置php配置文件
```bash
cp php.ini-production /usr/local/php/etc/php.ini
```

配置php-fpm文件
```bash
cp /usr/local/php/etc/php-fpm.conf.default /usr/local/php/etc/php-fpm.conf
cp /usr/local/php/etc/php-fpm.d/www.conf.default /usr/local/php/etc/php-fpm.d/www.conf
```

设置php-fpm开机启动
```bash
cp sapi/fpm/init.d.php-fpm /etc/rc.d/init.d/php-fpm
chmod 755 /etc/rc.d/init.d/php-fpm
chkconfig php-fpm on
```