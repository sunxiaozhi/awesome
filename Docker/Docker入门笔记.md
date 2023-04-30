**容器内的应用进程直接运行于宿主的内核，容器内没有自己的内核，而且也没有进行硬件虚拟。**

Docker的三个基本概念：

- 镜像（Image）
- 容器（Container）
- 仓库（Repository）

镜像（Image）和容器（Container）的关系，就像是面向对象程序设计中的类和实例一样，镜像是静态的定义，容器是镜像运行的实体。

### Docker命令

- docker pull
- docker run -it --rm
- **-i 让容器的标准输入保持打开 -t 让Docker分配一个伪终端（pseudo-tty）并绑定到容器的标准输入上 -d 后台运行 -v 制定一个数据卷，也可指定挂载一个本地主机目录到容器中去**
- **--rm 容器在终止之后立刻删除  --rm和-d不能同时使用**
- docker images -a -f since/before/lable= --formate
- docker image ls (推荐)
- docker image prune 删除虚悬镜像
- docker rmi $(docker images -q -f danling=true) 删除虚悬镜像
- docker rmi $(docker images -q redis) 删除所有的redis镜像
- docker rmi $(docker images -q before=mongo:3.2)
- docker run --name webserver -d -p 80:80 nginx
- docker diff
- docker commit
- docker build -t 容器名 .
- docker rmi 镜像名/镜像ID(分为长ID和短ID，一般使用短ID，取前3个字符以上，只要足够区分别的镜像就可以)/镜像摘要
- docker images --digests
- docker container
- docker start
- docker container run
- docker container start
- docker container ls
- docker container logs
- docker stop
- docker ps -a
- docker restart
- docker attach 进入容器进行操作  （也可用nsenter工具）
- docker export 导出本地的某个容器
- docker import
- docker container export
- dcoker image import
- docker rm -f     -f 删除正在运行的容器
- docker rm -v    删除容器的同时删除数据卷
- docekr rm $(docker ps -a -q)
- docekr login
- docker search
- docker push
- docker inspect 容器名   查看指定容器的信息
- docker network 管理Docker的网络
- docker port 容器名
- docker inspect -f "{{ .Name }}" 容器ID

### Dockfile指令

- From
- Run

容器是独立运行的一个或一组应用，以及它们的运行环境。

虚拟机是模拟运行的一整套操作系统（提供了运行态环境和其他系统环境）和跑在上面的应用。

### 容器的启动方式

- 基于镜像新建一个容器并启动
- 将在终止状态的（stopped）的容器重新启动
-

### 容器管理数据的主要方式
- 数据卷 （Data volumes）
- 数据卷容器 （Data volumes container）