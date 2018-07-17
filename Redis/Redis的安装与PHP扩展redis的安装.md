## Redis的安装
下载redis
```bash
wget http://download.redis.io/releases/redis-4.0.9.tar.gz
```
解压redis并进入
```bash
tar zxvf redis-4.0.9.tar.gz
cd redis-4.0.9
```
安装（无需编译，原包已编译）
```bash
make PREFIX=/usr/local/redis install
```
复制配置文件
```bash
mkdir -p /usr/local/redis/etc/
\cp redis.conf /usr/local/redis/etc/
```
修改配置文件（后台启动、解除ip绑定、修改密码）
```bash
sed -i 's/daemonize no/daemonize yes/g' /usr/local/redis/etc/redis.conf
sed -i 's/^# bind 127.0.0.1/bind 127.0.0.1/g' /usr/local/redis/etc/redis.conf
sed -i 's/^# requirepass foobared/requirepass 123456/g' /usr/local/redis/etc/redis.conf
```
启动redis
```bash
/usr/local/redis/bin/redis-server /usr/local/redis/etc/redis.conf
```

##PHP扩展redis的安装
下载redis
```bash
wget http://pecl.php.net/get/redis-4.0.0.tgz
```
解压并进入
```bash
tar zxvf redis-4.0.0.tgz
cd redis-4.0.0
```
安装redis扩展
```bash
phpize
./configure --with-php-config=/usr/local/bin/php-config
make && make install
```

在php.ini文件中添加
extension=redis.so

重启
killall php-fpm
php-fpm