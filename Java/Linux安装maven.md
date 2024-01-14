#Linux安装maven

## 下载安装包与解压
```shell
wget https://dlcdn.apache.org/maven/maven-3/3.9.6/binaries/apache-maven-3.9.6-bin.tar.gz

tar zxvf apache-maven-3.9.6-bin.tar.gz

mv apache-maven-3.9.6 /usr/local
```

## 配置环境变量
```shell
vim /etc/profile

# 最后面追加
export MAVEN_HOME=/usr/local/apache-maven-3.8.1/
export PATH=${PATH}:${MAVEN_HOME}/bin
```

重启环境变量
```shell
source /etc/profile 
```

## 验证是否安装成功
```shell
mvn -version
```

## 常见问题
若source /etc/profile在重新登陆之后不起作用，添加如下配置：
```shell
sudo vi ~/.bashrc

# 文件最后一行添加
source /etc/profile
```