# Linux安装Java17

## Java目录创建
```shell
cd /usr/lib/
mdkir jdk17
```

## 下载最新版本jdk
```shell
wget https://download.oracle.com/java/17/latest/jdk-17_linux-x64_bin.tar.gz
```

## 解压jdk包
```shell
tar -zxvf jdk压缩包
```

## 配置环境变量
```shell
vim /etc/profile
```

在profile文件最后添加
```shell
# jdk17
export JAVA_HOME=/usr/lib/jdk17/jdk解压包名
export CLASSPATH=.:$JAVA_HOME/lib/
export PATH=.:$JAVA_HOME/bin:$PATH
```

重启环境变量
```shell
source /etc/profile 
```

## 验证是否安装成功
```shell
java -version
```

## 常见问题
若source /etc/profile在重新登陆之后不起作用，添加如下配置：
```shell
sudo vi ~/.bashrc

# 文件最后一行添加
source /etc/profile
```