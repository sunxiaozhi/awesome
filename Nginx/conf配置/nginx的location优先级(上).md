在nginx配置文件中，location主要有这几种形式：
1. 正则匹配  location ~ /abc { }
2. 不区分大小写的正则匹配 location ~* /abc { }
3. 匹配路径的前缀，如果找到停止搜索 location ^~ /abc { }
4. 精确匹配  location = /abc { }
5.普通路径前缀匹配  location  /abc { }

先说优先级：

4  > 3  > 2  > 1 >  5

再来解释一下各个格式：

```bash
location  = / {
    # 精确匹配 / ，主机名后面不能带任何字符串
    [ configuration A ]
}
```

```bash
location  / {
    # 因为所有的地址都以 / 开头，所以这条规则将匹配到所有请求
    # 但是正则和最长字符串会优先匹配
    [ configuration B ]
}
```

```bash
location /documents/ {
    # 匹配任何以 /documents/ 开头的地址，匹配符合以后，还要继续往下搜索
    # 只有后面的正则表达式没有匹配到时，这一条才会采用这一条
    [ configuration C ]
}
```

```bash
location ~ /documents/Abc {
    # 匹配任何以 /documents/ 开头的地址，匹配符合以后，还要继续往下搜索
    # 只有后面的正则表达式没有匹配到时，这一条才会采用这一条
    [ configuration CC ]
}
```

```bash
location ^~ /images/ {
    # 匹配任何以 /images/ 开头的地址，匹配符合以后，停止往下搜索正则，采用这一条。
    [ configuration D ]
}
```
```bash
location ~* \.(gif|jpg|jpeg)$ {
    # 匹配所有以 gif,jpg或jpeg 结尾的请求
    # 然而，所有请求 /images/ 下的图片会被 config D 处理，因为 ^~ 到达不了这一条正则
    [ configuration E ]
}
```
```bash
location /images/ {
    # 字符匹配到 /images/，继续往下，会发现 ^~ 存在
    [ configuration F ]
}
```
```bash
location /images/abc {
    # 最长字符匹配到 /images/abc，继续往下，会发现 ^~ 存在
    # F与G的放置顺序是没有关系的
    [ configuration G ]
}
```
```bash
location ~ /images/abc/ {
    # 只有去掉 config D 才有效：先最长匹配 config G 开头的地址，继续往下搜索，匹配到这一条正则，采用
    [ configuration H ]
}
```