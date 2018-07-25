#### 慢查询日志概念

MySQL的慢查询日志是MySQL提供的一种日志记录，它用来记录在MySQL中响应时间超过阀值的语句，具体指运行时间超过long_query_time值的SQL，则会被记录到慢查询日志中。long_query_time的默认值为10，意思是运行10S以上的语句。默认情况下，Mysql数据库并不启动慢查询日志，需要我们手动来设置这个参数，当然，如果不是调优需要的话，一般不建议启动该参数，因为开启慢查询日志会或多或少带来一定的性能影响。慢查询日志支持将日志记录写入文件，也支持将日志记录写入数据库表。

#### 慢查询日志相关参数

MySQL 慢查询的相关参数解释：

slow_query_log ：是否开启慢查询日志，1表示开启，0表示关闭。

log-slow-queries ：旧版（5.6以下版本）MySQL数据库慢查询日志存储路径。可以不设置该参数，系统则会默认给一个缺省的文件host_name-slow.log

slow-query-log-file：新版（5.6及以上版本）MySQL数据库慢查询日志存储路径。可以不设置该参数，系统则会默认给一个缺省的文件host_name-slow.log

long_query_time ：慢查询阈值，当查询时间多于设定的阈值时，记录日志。

log_queries_not_using_indexes：未使用索引的查询也被记录到慢查询日志中（可选项）。

log_output：日志存储方式。log_output='FILE'表示将日志存入文件，默认值是'FILE'。log_output='TABLE'表示将日志存入数据库，这样日志信息就会被写入到mysql.slow_log表中。MySQL数据库支持同时两种日志存储方式，配置的时候以逗号隔开即可，如：log_output='FILE,TABLE'。日志记录到系统的专用日志表中，要比记录到文件耗费更多的系统资源，因此对于需要启用慢查询日志，又需要能够获得更高的系统性能，那么建议优先记录到文件。

#### 开启慢查询

修改my.cnf配置文件，在[mysqld]添加

```
slow_query_log = ON
log_query_time = 1
```

重启mysql

```
systemctl restart mysqld
```

通过select sleep(3)和select sleep(0.5)测试慢日志查询是否开启。如果成功，则会记入慢日志中。

#### 慢日志存储在表中

```
set global log_output='TABLE';

select sleep(4);

select * from mysql.slow_log;
```

#### 其他优化项

系统变量log-queries-not-using-indexes：未使用索引的查询也被记录到慢查询日志中（可选项）。如果调优的话，建议开启这个选项。另外，开启了这个参数，其实使用full index scan的sql也会被记录到慢查询日志。

系统变量log_slow_admin_statements表示是否将慢管理语句例如ANALYZE TABLE和ALTER TABLE等记入慢查询日志。

查询有多少条慢查询语句，可以使用系统变量
```
show global status like '%Slow_queries%';
```

#### 日志分析工具mysqldumpslow

在生产环境中，如果要手工分析日志，查找、分析SQL，显然是个体力活，MySQL提供了日志分析工具mysqldumpslow

查看mysqldumpslow的帮助信息：

```
[root@DB-Server ~]# mysqldumpslow --help
Usage: mysqldumpslow [ OPTS... ] [ LOGS... ]

Parse and summarize the MySQL slow query log. Options are

  --verbose    verbose
  --debug      debug
  --help       write this text to standard output

  -v           verbose
  -d           debug
  -s ORDER     what to sort by (al, at, ar, c, l, r, t), 'at' is default
                al: average lock time
                ar: average rows sent
                at: average query time
                 c: count
                 l: lock time
                 r: rows sent
                 t: query time
  -r           reverse the sort order (largest last instead of first)
  -t NUM       just show the top n queries
  -a           don't abstract all numbers to N and strings to 'S'
  -n NUM       abstract numbers with at least n digits within names
  -g PATTERN   grep: only consider stmts that include this string
  -h HOSTNAME  hostname of db server for *-slow.log filename (can be wildcard),
               default is '*', i.e. match all
  -i NAME      name of server instance (if using mysql.server startup script)
  -l           don't subtract lock time from total time
```

```
-s, 是表示按照何种方式排序，

    c: 访问计数

    l: 锁定时间

    r: 返回记录

    t: 查询时间

    al:平均锁定时间

    ar:平均返回记录数

    at:平均查询时间

-t, 是top n的意思，即为返回前面多少条的数据；

-g, 后边可以写一个正则匹配模式，大小写不敏感的；
```

比如：

得到返回记录集最多的10个SQL。

```
mysqldumpslow -s r -t 10 /database/mysql/mysql06_slow.log
```

得到访问次数最多的10个SQL
```
mysqldumpslow -s c -t 10 /database/mysql/mysql06_slow.log
```
得到按照时间排序的前10条里面含有左连接的查询语句。
```
mysqldumpslow -s t -t 10 -g “left join” /database/mysql/mysql06_slow.log
```
另外建议在使用这些命令时结合 | 和more 使用 ，否则有可能出现刷屏的情况。
```
mysqldumpslow -s r -t 20 /mysqldata/mysql/mysql06-slow.log | more
```