### 先安装依赖软件
```bash
yum -y install gcc libevent libevent-devel
```

### 源码安装memcached
```bash
cd /usr/local/src

wget http://memcached.org/files/memcached-1.5.2.tar.gz

tar -zxvf memcached-1.5.2.tar.gz

cd memcached-1.5.2

./configure --prefix=/usr/local/memcached

make && sudo make install
```