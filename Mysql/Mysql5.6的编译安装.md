创建软件存放目录
```bash
mkdir /home/soft/
cd /home/soft/
```

卸载mariadb
yum -y remove maria*

rm /etc/my.cnf

下载mysql5.6的源码包
```bash
wget https://dev.mysql.com/get/Downloads/MySQL-5.6/mysql-5.6.40.tar.gz
```

解压mysql5.6的源码包
```bash
tar zxvf mysql-5.6.40.tar.gz
```

依赖包
```bash
yum -y install gcc gcc-c++ ncurses-devel bison bison-devel perl perl-devel autoconf
```

安装cmake
```
yum -y install cmake
```

添加MySQL运行账户和组

```bash
groupadd mysql
useradd -s /sbin/nologin -M -g mysql mysql
```

编译mysql

```bash
cmake . -DCMAKE_INSTALL_PREFIX=/usr/local/mysql \
-DSYSCONFDIR=/etc \
-DWITH_MYISAM_STORAGE_ENGINE=1 \
-DWITH_INNOBASE_STORAGE_ENGINE=1 \
-DWITH_PARTITION_STORAGE_ENGINE=1 \
-DWITH_FEDERATED_STORAGE_ENGINE=1 \
-DEXTRA_CHARSETS=all \
-DDEFAULT_CHARSET=utf8mb4 \
-DDEFAULT_COLLATION=utf8mb4_general_ci \
-DWITH_EMBEDDED_SERVER=1 \
-DENABLED_LOCAL_INFILE=1 \
```

```bash
make && make install
```

修改文件夹权限
```bash
chown -R root:mysql /usr/local/mysql/

chown -R mysql:mysql /usr/local/mysql/data/
```

拷贝配置文件my.cnf
```bash
cp /usr/local/mysql/support-files/my-default.cnf /etc/my.cnf

vi /etc/my.cnf
[mysqld]
basedir = /usr/local/mysql
datadir = /usr/local/mysql/data
port = 3306
# server_id = .....
socket = /tmp/mysql.sock
```

初始化数据库
```bash
/usr/local/mysql/scripts/mysql_install_db --defaults-file=/etc/my.cnf --basedir=/usr/local/mysql --datadir=/usr/local/mysql/data --user=mysql
```

设置成开机启动
```bash
cp /usr/local/mysql/support-files/mysql.server /etc/init.d/mysqld

chmod 755 /etc/init.d/mysqld

chkconfig mysqld on
```

设置mysql环境变量
```bash
vi /etc/profile
添加：
export PATH=$PATH:/usr/local/mysql/bin

source /etc/profile
```

初始化MySQL及相关安全选项配置

```bash
mysql_secure_installation
```

firewall-cmd --permanent --add-port=3306/tcp

firewall-cmd --reload

配置192.168.20.65可以通过root:123456访问数据库

GRANT ALL PRIVILEGES ON *.* to 'root'@'192.168.20.65' IDENTIFIED BY '123456' WITH GRANT OPTION;

从mysql数据库中的授权表重新载入权限

flush privileges;