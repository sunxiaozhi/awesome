1、查看 yum 源仓库的 Git 信息：
```bash
yum info git
```

可以看出，截至目前，yum 源仓库中最新的 Git 版本才 1.8.3.1，而查看最新的 Git 发布版本，已经 2.9.2 了。

2、依赖库安装
```bash
yum -y install curl-devel expat-devel gettext-devel openssl-devel zlib-devel
yum -y install  gcc perl-ExtUtils-MakeMaker
```

3、卸载低版本的 Git

通过命令：git --version 查看系统带的版本，Git 版本是：1.8.3.1，所以先要卸载低版本的 Git，命令：
```bash
yum remove git
```

4、下载新版的 Git 源码包
```bash
wget https://github.com/git/git/archive/v2.21.0.tar.gz
```

也可以离线下载，然后传到 CentOS 系统中指定的目录下。

5、解压到指定目录

```bash
tar -xzvf v2.21.0.tar.gz
```

6、安装 Git

分别执行以下命令进行编译安装，编译过程可能比较漫长，请耐心等待完成。

```bash
cd git-2.21.0
make prefix=/usr/local/git all
make prefix=/usr/local/git install
```

7、添加到环境变量
```bash
echo "export PATH=$PATH:/usr/local/git/bin" >> /etc/bashrc
source /etc/bashrc
```

8、查看版本号
```bash
git --version
```
至此，CentOS 就安装上了最新版本的 Git。

