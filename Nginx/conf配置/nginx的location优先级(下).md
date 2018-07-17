再来分析一下A-H配置的执行顺序。

1. 下面2个配置同时存在时
```bash
location = / {
    [ configuration A ]
}

location / {
    [ configuration B ]
}
```
此时A生效，因为=/优先级高于/。

2. 下面3个配置同时存在时
```bash
location  /documents/ {
    [ configuration C ]
}
location ~ /documents/ {
    [configuration CB]
}
location ~ /documents/abc {
    [ configuration CC ]
}
```
当访问的url为/documents/abc/1.html，此时CC生效，首先CB优先级高于C，而CC更优先于CB。

3. 下面4个配置同时存在时
```bash
location ^~ /images/ {
    [ configuration D ]
}

location /images/ {
    [ configuration F ]
}

location /images/abc {
    [ configuration G ]
}

location ~ /images/abc/ {
    [ configuration H ]
}
```
当访问的链接为/images/abc/123.jpg时，此时D生效。虽然4个规则都能匹配到，但^~优先级是最高的。

若^~不存在时，H优先，因为~/images/ > /images/。

而/images/和/images/abc同时存在时，/images/abc优先级更高，因为后者更加精准。

4. 下面两个配置同时存在时
```bash
location ~* \.(gif|jpg|jpeg)$ {
    [ configuration E ]
}

location ~ /images/abc/ {
    [ configuration H ]
}
```
当访问的链接为/images/abc/123.jpg时，E生效。因为上面的规则更加精准。