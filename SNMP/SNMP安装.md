# SNMP安装-Centos

## 安装SNMP
```shell script
yum install -y net-snmp net-snmp-devel net-snmp-utils
```

## 配置SNMP
```shell script
[root@sun ~]# cat /etc/snmp/snmpd.conf |grep -vE "^#|^$"
com2sec notConfigUser  default       public
group   notConfigGroup v1           notConfigUser
group   notConfigGroup v2c           notConfigUser
view    systemview    included   .1.3.6.1.2.1.1
view    systemview    included   .1.3.6.1.2.1.25.1.1
access  notConfigGroup  ""  any  noauth  exact  systemview none none
syslocation Unknown (edit /etc/snmp/snmpd.conf)
syscontact Root <root@localhost> (configure /etc/snmp/snmp.local.conf)
dontLogTCPWrappersConnects yes
 
参数说明：
# 格式：com2sec   [-Cn context]   sec.name   source   community
# com2sec：固定命令
# [-Cn context]：可选的，在v3版本中使用
# sec.name:  内部映射的名字，字符串，建组的时候需要用到
# source: 可以访问的ip地址范围，默认值"default”，即任何ip都可以访问.也可以使用限制192.168.1.0/24,或者192.168.1.0/255.255.255.0
# community: 实体字符串，外部使用的名字
com2sec notConfigUser  default       public
 
# 格式：group   groupName   securityModel   sec.name
# group: 固定命令
# groupName: 组名
# securityMode1: v1,v2c,usm,tsm,ksm
# sec.name：将sec.name映射到一个group中，组中具有相同的存取权限。
group   notConfigGroup v2c  notConfigUser
 
# 格式：view viewName type oid [mask]
# view: 定义一个view，表示整个OID树中的子树，同一个子树可定义多个view
# viewName: view名字
# type: included和exclude(包括和排除)
# oid: 可访问的oid
# [mask]: 对oid的mask
例：view all include 1.3.6.1.2.1.4  0xf0
# 0xf0：1111 0000，即访问的oid的前4位必须是1.3.6.1，否则不能访问，即可以访问1.3.6.1下所有的子oid
view    systemview    included   .1.3.6.1.2.1.25.1.1
 
# 格式：access groupName context model level prefx view read write 
# access：设置访问某一个view的权限
# groupName：控制存取权限的组名
# context:v1和v2c版本，context必须设置为""
# mode1：v1、v2c、usm、tsm、ksm。最后三种为v3版本授权模式，usm(基于用户的验证)，tsm（SSH or DTLS),)ksm(用于支持Kerberos)
# level: noauth、auth、priv。noauth(允许无权限访问，v1,v2c可用)，auth(必须有权限才能访问),pric(强制加密访问)
# prefx: exact or prefix(精确或前缀)
# view read、write：指明某一个view的权限是否可以GET*, SET*，如果该view不能read或write,则设置none
access  notConfigGroup  ""  any  noauth  exact  systemview none none
 
# 如果不注释掉，会生产日志到log里，仅在调试时关闭
dontLogTCPWrappersConnects yes
 
syslocation Unknown (edit /etc/snmp/snmpd.conf)
syscontact Root <root@localhost> (configure /etc/snmp/snmp.local.conf)
 
其他具体参数，请参照官方说明 http://www.NET-snmp.org/docs/man/snmpd.conf.html
```

## 启动SNMP
```shell script
systemctl start snmpd.service
```

## 设置SNMP为自启动服务
```shell script
systemctl enable snmpd.service
```

## 验证服务是否成功
```shell script
[root@sun ~]# snmpwalk -v 2c -c public localhost sysName
SNMPv2-MIB::sysName.0 = STRING: sun.abc.com
# 如上，可以得到主机名，表示SNMP服务可以正常使用
 
[root@sun ~]# snmptranslate -To|head -n3
.1.3
.1.3.6
.1.3.6.1
# 如上，表示SNMP工具可以使用
 
[root@sun ~]# snmpwalk -v 2c -c public IP sysName
# IP替换为服务器真实IP
# 测试远程Linux服务是否正常，如果得不到远程主机名，检查远程Linux防火墙
 
[root@sun ~]# snmpwalk -v 2c -c public localhost 1.3.6.1.4.1.2021.11.11.0
UCD-SNMP-MIB::ssCpuIdle.0 = No more variables left in this MIB View (It is past the end of the MIB tree)
# 如上表示无法获取CPU空闲状态（注：1.3.6.1.4.1.2021.11.11.0是主机CPU空闲率的oid）
```

## 获取主机其他重要信息，需要修改SNMP的默认配置信息
```shell script
view    systemview    included   .1.3.6.1.2.1.25.1.1
# view定义了可以访问哪些节点设备信息
view        systemview        included      ./
#  使访问所有的信息（较危险）
```

## 注意事项
注意：需要防火墙开启UDP 161端口