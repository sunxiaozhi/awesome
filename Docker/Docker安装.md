## Docker的安装

#### 移除旧版本
```bash
sudo yum remove docker \
                  docker-client \
                  docker-client-latest \
                  docker-common \
                  docker-latest \
                  docker-latest-logrotate \
                  docker-logrotate \
                  docker-selinux \
                  docker-engine-selinux \
                  docker-engine
```

#### 安装一些必要的系统工具
```bash
sudo yum install -y yum-utils device-mapper-persistent-data lvm2
```

#### 添加软件源信息
```bash
sudo yum-config-manager --add-repo http://mirrors.aliyun.com/docker-ce/linux/centos/docker-ce.repo
```

#### 更新yum缓存
```bash
sudo yum makecache fast
```

#### 安装 Docker-ce
```bash
sudo yum -y install docker-ce
```

#### 启动 Docker 后台服务
```bash
sudo systemctl start docker
```

## 使用第三方加速
```bash
curl -sSL https://get.daocloud.io/daotools/set_mirror.sh | sh -s http://f1361db2.m.daocloud.io

sudo systemctl daemon-reload

sudo systemctl restart docker
```

## Docker-compose的安装
```bash
安装python-pip
yum -y install epel-release
yum -y install python-pip

安装docker-compose
pip install docker-compose

待安装完成后，执行查询版本的命令
docker-compose version
```
