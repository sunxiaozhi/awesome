### 开启80端口

> firewall-cmd --zone=public --add-port=80/tcp --permanent

**出现success表明添加成功**
 
命令含义：

--zone #作用域

--add-port=80/tcp  #添加端口，格式为：端口/通讯协议

--permanent   #永久生效，没有此参数重启后失效

### 重启防火墙

> systemctl restart firewalld.service
 
## 1、运行、停止、禁用firewalld

启动：# systemctl start  firewalld

查看状态：# systemctl status firewalld 或者 firewall-cmd --state

停止：# systemctl disable firewalld

禁用：# systemctl stop firewalld

## 2、配置firewalld

查看版本：$ firewall-cmd --version

查看帮助：$ firewall-cmd --help

### 查看设置：

**显示状态：** $ firewall-cmd --state

**查看区域信息:** $ firewall-cmd --get-active-zones

**查看指定接口所属区域：** $ firewall-cmd --get-zone-of-interface=eth0

**拒绝所有包：** # firewall-cmd --panic-on

**取消拒绝状态：** # firewall-cmd --panic-off

**查看是否拒绝：** $ firewall-cmd --query-panic
 
**更新防火墙规则：**

> firewall-cmd --reload

> firewall-cmd --complete-reload

两者的区别就是第一个无需断开连接，就是firewalld特性之一动态添加规则，第二个需要断开连接，类似重启服务
 
将接口添加到区域，默认接口都在public

> firewall-cmd --zone=public --add-interface=eth0

永久生效再加上 --permanent 然后reload防火墙
 
设置默认接口区域：
> firewall-cmd --set-default-zone=public

立即生效无需重启
 
打开端口（貌似这个才最常用）查看所有打开的端口：

> firewall-cmd --zone=dmz --list-ports

加入一个端口到区域：

> firewall-cmd --zone=dmz --add-port=8080/tcp

若要永久生效方法同上
 
打开一个服务，类似于将端口可视化，服务需要在配置文件中添加，/etc/firewalld目录下有services文件夹，这个不详细说了，详情参考文档

> firewall-cmd --zone=work --add-service=smtp
 
移除服务

> firewall-cmd --zone=work --remove-service=smtp

## 3、FirewallD 的区域zone

FirewallD 使用服务service 和区域zone来代替 iptables 的规则rule和链chain。

默认情况下，有以下的区域zone可用：
* drop – 丢弃所有传入的网络数据包并且无回应，只有传出网络连接可用。
* block — 拒绝所有传入网络数据包并回应一条主机禁止的 ICMP 消息，只有传出网络连接可用。
* public — 只接受被选择的传入网络连接，用于公共区域。
* external — 用于启用了地址伪装的外部网络，只接受选定的传入网络连接。
* dmz — DMZ 隔离区，外部受限地访问内部网络，只接受选定的传入网络连接。
* work — 对于处在你工作区域内的计算机，只接受被选择的传入网络连接。
* home — 对于处在你家庭区域内的计算机，只接受被选择的传入网络连接。
* internal — 对于处在你内部网络的计算机，只接受被选择的传入网络连接。
* trusted — 所有网络连接都接受。

要列出所有可用的区域，运行：
>firewall-cmd --get-zones

列出默认的区域 ：
>firewall-cmd --get-default-zone

改变默认的区域 ：
>firewall-cmd --set-default-zone=dmz