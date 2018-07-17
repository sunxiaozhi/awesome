## 网络时间同步：

设置好时区之后，使用ntp同步标准时间。

ntp：网络时间协议（network time protol)

安装：
```bash
yum -y install ntp
```

同步：
```bash
ntpdate pool.ntp.org
```

## Centos7下安装netstat
```bash
yum -y install net-tools
```