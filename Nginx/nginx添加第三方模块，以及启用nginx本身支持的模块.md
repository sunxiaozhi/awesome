首先，要讲清楚一点，nginx不支持动态安装、加载模块的，所以当你安装第三方模块或者启动nginx本身的新模块功能的时候，都是覆盖nginx的。

所以，一定要注意：首先查看你已经安装的nginx模块！然后安装新东西的时候，要把已安装的，再次配置。

nginx第三方模块安装方法：

```bash
./configure --prefix=/你的安装目录  --add-module=/第三方模块目录
```

上面已经讲清楚了，安装任何新功能的时候，一定要先查看现有的，

第一步：查看nginx现有的配置

```bash
cd /usr/local/sbin/
./nginx -V   查看configure arguments: 后面的项，有可能是空的，说明什么都没有配置。
```

举例：

configure arguments: --add-module=/home/softback/echo-nginx-module-0.60

说明已经安装了第三方的echo模块。

那么下面再安装https支持，或者其它第三方模块的时候，./configure后面一定还要带上--add-module=/home/softback/echo-nginx-module-0.60  ，否则会被覆盖的。

第二步：安装模块

1、在未安装nginx的情况下安装nginx第三方模块(需要make install)
```bash
 ./configure --prefix=/usr/local/nginx \
--with-http_stub_status_module \
--with-http_ssl_module --with-http_realip_module \
--with-http_image_filter_module \
--add-module=../ngx_pagespeed-master --add-module=/第三方模块目录
 make
 make isntall
 /usr/local/nginx/sbin/nginx
 ```

2、在已安装nginx情况下安装nginx模块(不需要make install，只需要make)
```bash
 ./configure --prefix=/usr/local/nginx \
 --with-http_stub_status_module \
 --with-http_ssl_module --with-http_realip_module \
 --with-http_image_filter_module \
 --add-module=../ngx_pagespeed-master
 make
 /usr/local/nginx/sbin/nginx -s stop
 cp /usr/local/nginx/sbin/nginx /usr/local/nginx/sbin/nginx.bak
 cp objs/nginx /usr/local/nginx/sbin/nginx
 /usr/local/nginx/sbin/nginx //启动nginx
```

总结,安装nginx安装第三方模块实际上是使用--add-module重新安装一次nginx，不要make install而是直接把编译目录下objs/nginx文件直接覆盖老的nginx文件.如果你需要安装多个nginx第三方模块,你只需要多指定几个相应的--add-module即可.

备注：重新编译的时候，记得一定要把以前编译过的模块一同加到configure参数里面.