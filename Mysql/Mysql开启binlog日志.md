开启binlog日志(在[mysqld]下修改或添加如下配置)：
```
server-id=1
log_bin=mysql_bin
binlog_format=MIXED
```

### binlog日志模式

Mysql复制主要有三种方式：基于SQL语句的复制(statement-based replication, SBR)，基于行的复制(row-based replication, RBR)，混合模式复制(mixed-based replication, MBR)。对应的，binlog的格式也有三种：STATEMENT，ROW，MIXED。

#### 1、STATEMENT模式（SBR）

每一条会修改数据的sql语句会记录到binlog中。优点是并不需要记录每一条sql语句和每一行的数据变化，减少了binlog日志量，节约IO，提高性能。缺点是在某些情况下会导致master-slave中的数据不一致(如sleep()函数， last_insert_id()，以及user-defined functions(udf)等会出现问题)

#### 2、ROW模式（RBR）
不记录每条sql语句的上下文信息，仅需记录哪条数据被修改了，修改成什么样了。而且不会出现某些特定情况下的存储过程、或function、或trigger的调用和触发无法被正确复制的问题。缺点是会产生大量的日志，尤其是alter table的时候会让日志暴涨。

#### 3、MIXED模式（MBR）
以上两种模式的混合使用，一般的复制使用STATEMENT模式保存binlog，对于STATEMENT模式无法复制的操作使用ROW模式保存binlog，MySQL会根据执行的SQL语句选择日志保存方式。

查看默认的日志保存天数
```
show variables like '%expire_logs_days%';
```
0-表示永不过期

设置为7天有效期(修改配置文件)
```
expire_logs_days=7
```

binlog使用
```
mysqlbinlog /usr/local/mysql/data/mysql-bin.000001
```