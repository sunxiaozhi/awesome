操作系统：CentOS-7-x86_64
MySQL 版本：mysql-5.6.40.tar.gz
主节点 IP：192.168.20.65        主机名：master
从节点 IP：192.168.20.66        主机名：slave

#### MySQL 主从复制（也称 A/B 复制）的原理
* Master将数据改变记录到二进制日志(binary log)中，也就是配置文件 log-bin 指定的文件，这些记录叫做二进制日志事件(binary log events)；
* Slave通过 I/O 线程读取 Master 中的 binary log events并写入到它的中继日志(relay log)；
* Slave重做中继日志中的事件，把中继日志中的事件信息一条一条的在本地执行一次，完成数据在本地的存储，从而实现将改变反映到它自己的数据(数据重放)。

#### 主从配置需要注意的点
* 主从服务器操作系统版本和位数一致；主从服务器的hostname不要一致。
* Master和Slave数据库的版本要一致；
* Master和Slave数据库中的数据要一致；
* Master开启二进制日志，Master和Slave的server_id在局域网内必须唯一；
* Master和Slave都创建数据库witcms；

## Master的配置

Master（192.168.20.65）和 Slave（192.168.20.66）注意：两台数据库服务器的的selinux都要disable（永久关闭 selinux，请 修改/etc/selinux/config，将SELINUX改为disabled）

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
 log-bin=mysql-bin
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

```
systemctl restart mysqld.service

grant replication slave,replication client on *.* to 'repl'@'192.168.20.66' identified by '123456';

flush privileges;

show master status\G;
```

## Slave的配置

#### 修改Slave的配置文件

```
vi  /etc/my.cnf

## 在 [mysqld] 中增加以下配置项
# 设置 server_id，一般设置为 IP
server_id=66
# 复制过滤：需要备份的数据库，输出 binlog
binlog-do-db=witcms
#复制过滤：不需要备份的数据库，不输出（mysql 库一般不同步）
binlog-ignore-db=mysql
# 开启二进制日志，以备 Slave 作为其它 Slave 的 Master 时使用
log-bin=mysql-bin
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

```
systemctl restart mysqld.service

change master to master_host='192.168.20.65', master_user='repl', master_password='123456', master_port=3306, master_log_file='mysql-bin.000001', master_log_pos=422, master_connect_retry=30;

show slave status\G;
```
