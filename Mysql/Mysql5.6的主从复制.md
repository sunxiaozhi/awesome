操作系统：CentOS-7-x86_64
MySQL 版本：mysql-5.6.40.tar.gz
主节点 IP：192.168.20.65        主机名：master
从节点 IP：192.168.20.66        主机名：slave

#### MySQL 主从复制（也称 A/B 复制）的原理
* Master 将数据改变记录到二进制日志(binary  log)中，也就是配置文件 log-bin 指定的文件，这些记录叫做二进制日志事件(binary  log  events)；
* Slave 通过 I/O 线程读取 Master 中的 binary  log  events 并写入到它的 中继日志(relay  log)；
* Slave 重做中继日志中的事件，把中继日志中的事件信息一条一条的在 本地执行一次，完成数据在本地的存储，从而实现将改变反映到它自己的 数据(数据重放)。

#### 主从配置需要注意的点
* 主从服务器操作系统版本和位数一致；主从服务器的 hostname 不要一致。
* Master 和 Slave 数据库的版本要一致；
* Master 和 Slave 数据库中的数据要一致；
* Master 开启二进制日志，Master 和 Slave 的 server_id 在局域网内必 须唯一；
* Master 和 Slave 都创建数据库witcms，表testuser；

## Master的配置

Master（192.168.20.65）和 Slave（192.168.20.66） 注意：两台数据库服务器的的 selinux 都要 disable（永久关闭 selinux，请 修改/etc/selinux/config，将 SELINUX 改为 disabled）

修改Master的配置文件

```
vi  /etc/my.cnf

# 在 [mysqld] 中增加以下配置项
# 设置 server_id，一般设置为 IP
 server_id=65
# 复制过滤：需要备份的数据库，输出 binlog
 binlog-do-db=witcms
# 复制过滤：不需要备份的数据库，不输出（mysql 库一般不同步）
 binlog-ignore-db=mysql
# 开启二进制日志功能，可以随便取，最好有含义
 log-bin=edu-mysql-bin
# 为每个 session 分配的内存，在事务过程中用来存储二进制日志的缓存
 binlog_cache_size=1M
# 主从复制的格式（mixed,statement,row，默认格式是 statement）
 binlog_format=mixed
# 二进制日志自动删除/过期的天数。默认值为 0，表示不自动删除。
 expire_logs_days=7
# 跳过主从复制中遇到的所有错误或指定类型的错误，避免 slave 端复制中断。
# 如：1062 错误是指一些主键重复，1032 错误是因为主从数据库数据不一 致
 slave_skip_errors=1062
# 如果需要同步函数或者存储过程
 log_bin_trust_function_creators=true
```

重启mysql服务器
```
systemctl restart mysqld.service
```

创建slave复制权限账号
```
mysql>grant replication slave,replication client on *.* to 'repl'@'192.168.20.66' identified by '123456';
```

刷新授权表信息
```
mysql>flush privileges;
```

查看position号，记下position号（从机上需要用到这个position号和现在的日志文件)
```
mysql>show master status\G;
```

## Slave的配置

#### 修改Slave的配置文件

```
vi  /etc/my.cnf

## 在 [mysqld] 中增加以下配置项
# 设置 server_id，一般设置为 IP
server_id=59
# 复制过滤：需要备份的数据库，输出 binlog
binlog-do-db=witcms
#复制过滤：不需要备份的数据库，不输出（mysql 库一般不同步）
binlog-ignore-db=mysql
# 开启二进制日志，以备 Slave 作为其它 Slave 的 Master 时使用
log-bin=edu-mysql-slave1-bin
# 为每个 session 分配的内存，在事务过程中用来存储二进制日志的缓存
binlog_cache_size=1M
# 主从复制的格式（mixed,statement,row，默认格式是 statement）
binlog_format=mixed
# 二进制日志自动删除/过期的天数。默认值为 0，表示不自动删除。
expire_logs_days=7
# 跳过主从复制中遇到的所有错误或指定类型的错误，避免 slave 端复制中 断。
# 如：1062 错误是指一些主键重复，1032 错误是因为主从数据库数据不一 致
slave_skip_errors=1062
#relay_log 配置中继日志
relay_log=mysql-relay-bin
#log_slave_updates 表示 slave 将复制事件写进自己的二进制日志
log_slave_updates=1
# 防止改变数据(除了特殊的线程)
read_only=1
```

#### 重启mysql服务器
```
systemctl restart mysqld.service
```

#### 设置从Master拉取bin-log日志(Master的IP、端口、同步用户、密码、position 号、读取哪个日志文件)
```
mysql>change master to master_host='192.168.0.%', master_user='repl', master_password='123456', master_port=3306, master_log_file='mysql_bin.000012', master_log_pos=422, master_connect_retry=30;
```

```
上面执行的命令的解释：
master_host='192.168.31.57'                        ##  Master 的 IP 地址
master_user='repl' 　　　　　　　　　　　　    ## 用于同步数据的用户（在 Master 中授权的用户）
master_password='123456'                          ## 同步数据用户的密码
master_port=3306   　　　　　　　　　　      ##  Master 数据库服务的端口
master_log_file='edu-mysql-bin.000001'     ##指定 Slave 从哪个日志文 件开始读复制数据（可在 Master 上使用 show  master  status 查看到日志 文件名）
master_log_pos=429                                  ## 从哪个 POSITION 号开始读
master_connect_retry=30                          ##当重新建立主从连接时，如果连接 建立失败，间隔多久后重试。单位为秒，默认设置为 60 秒，同步延迟调优 参数。
```

#### 查看主从同步状态
```
mysql>show slave status\G;
```

可看到 Slave_IO_State 为空， Slave_IO_Running 和 Slave_SQL_Runnin g 是 No，表明 Slave 还没有开始复制过程。

#### 开启主从同步

```
mysql>start slave;
```

#### 再查看主从同步状态
```
mysql>show slave status\G;
```

主要看以下两个参数，这两个参数如果是Yes就表示主从同步正常

```
Slave_IO_Running:  Yes
Slave_SQL_Running:  Yes
```

#### 可查看 master 和 slave 上线程的状态。在 master 上，可以看到 slave 的 I/O 线程创建的连接：

```
Master:
mysql>show processlist\G;
　　(1)row 为处理 slave 的 I/O 线程的连接。
　　(2)row 为处理 MySQL 客户端连接线程。
　　(3)row 为处理本地命令行的线程。
```
```
Slave:
mysql>show processlist\G;
　  (1) row 为 I/O 线程状态。
  　(2) row 为 SQL 线程状态。
    (3) row 为处理本地命令行的线程。
```

## 主从数据复制同步测试

在Master中的witcms库上变更数据的同步测试；
```
mysql>INSERT INTO `testuser`(`usercode`,`username`) VALUES (`1`, '同步测试 1'),(  `2`,'同步测试 2');
```
Master中添加完之后，登录Slave中查看数据是否已同步。

#### 测试过程中，如果遇到同步出错，可在Slave上重置主从复制设置（选 操作）：
```
mysql>reset slave;
```
重复之前的slave的从Master拉取日志设置操作

注意：如果在Slave没做只读控制的情况下，千万不要在Slave中手动插入数据，那样数据就会不一致，主从就会断开，就需要重新配置了。

双向主从其实就是Master和Slave都开启日志功能，然后在Master执行授权用户（这里授权的是自己作为从服务器，也就是这里的IP地址是Master的IP地址），然后再在Master上进行chang master操作。

## 虚拟机直接复制的系统，可能会出现的问题

* server_id相同，会在同步时出错，主从的server_id不能一样，必须唯一。

* uuid相同

进入mysql的data目录，打开auto.cnf文件，里面记录了数据库的uuid，每个库的uuid应该是不一样的。
```
server-uuid=6dcee5be-8cdb-11e2-9408-90e2ba2e2ea6
```
解决办法，按照这个16进制格式，随便改下，重启mysql即可。
