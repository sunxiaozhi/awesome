### 进入php源码包内ext下openssl的扩展源码文件中

```bash
cd /path/php-版本/ext/openssl
```

### 复制文件
```bash
cp config0.m4 config.m4
```

### 执行phpize
```bash
/path/php/bin/phpize
```

### 检测系统配置，对即将安装的软件进行配置
```bash
./configure --with-openssl --with-php-config=/path/php/bin/php-config
```

### 编译并安装
```bash
make && make install
```

### 在php.ini文件中引入openssl扩展
```bash
extension=openssl
```


* 针对其他php扩展，也可按照如此步骤进行安装。config0.m4复制这一步，按需进行。