nginx中的stub_status模块主要用于查看Nginx的一些状态信息. 本模块默认没有安装，需要编译安装。nginx开启stub_status模块配置方法如下：

1）查看nginx时候有安装该模块。
```bash
/usr/local/nginx/sbin/nginx -V
```
注意是大写的V,小写的v是查看版本信息的

2）安装stub_status模块（注意：有的话可以忽略此步骤，就不用安装了）

nginx有一个统计功能模块，编译安装的时候加上参数 "--with-http_stub_status_module",就安装了这个模块。
命令如下：
```bash
 ./configure --with-http_stub_status_module
```

3）修改nginx配置文件
在server块下面加上如下配置：

```bash
#性能统计 add@2018-3-28
location /nginx_status{
    allow --------//允许的ip
    allow --------//允许的ip
    deny all;     //拒绝所有
    stub_status  on;
    access_log   off;
}
```

4）重启nginx

修改配置文件后，先检查配置文件语法是否正确，正确的话重启。

```bash
/usr/local/nginx/sbin/nginx -t
/usr/local/nginx/sbin/nginx -s reload
```

5）在浏览器中输入 "域名/nginx_status" 就会显示nginx上次启动以来工作状态的统计的结果。

```bash
Active connections: 2 
server accepts handled requests
 13057 13057 11634
Reading: 0 Writing: 1 Waiting: 1 
```

6）返回各数据项说明：

Active connections: 当前nginx正在处理的活动连接数.

Server accepts handled requests:

nginx总共处理了13057 个连接,成功创建13057 握手(证明中间没有失败的),总共处理了11634 个请求。

Reading: nginx读取到客户端的Header信息数。

Writing: nginx返回给客户端的Header信息数。

Waiting: 开启keep-alive的情况下,这个值等于 active – (reading + writing),意思就是nginx已经处理完成,正在等候下一次请求指令的驻留连接。

所以,在访问效率高,请求很快被处理完毕的情况下,Waiting数比较多是正常的.如果reading +writing数较多,则说明并发访问量非常大,正在处理过程中。

