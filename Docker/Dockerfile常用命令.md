## Dockerfile常用命令

#### FROM
指定base镜像。

#### MAINTAINER
设置镜像的作者，可以是任意字符串。

#### COPY
将文件从build context复制到镜像。

COPY 支持两种形式：
```bash
COPY src dest

COPY ["src", "dest"]
```

> 注意：src只能指定build context中的文件或目录。

#### ADD
与COPY类似，从build context复制文件到镜像。不同的是，如果src是归档文件（tar,zip,tgz,xz等），文件会被自动解压到dest。

#### ENV
设置环境变量，环境变量可被后面的指令使用。例如：

```bash
ENV MY_VERSION 1.3

RUN apt-get install -y mypackage=$MY_VERSION
```

#### EXPOSE
指定容器中的进程会监听某个端口，Docker可以将该端口暴露出来。

#### VOLUME
将文件或目录声明为volume。

#### WORKDIR
为后面的RUN,CMD,ENTRYPOINT,ADD或COPY指令设置镜像中的当前工作目录。

#### RUN
在容器中运行指定的命令。

#### CMD
容器启动时运行指定的命令。

Dockerfile中可以有多个CMD指令，但只有最后一个生效。CMD可以被docker run之后的参数替换。

#### ENTRYPOINT
设置容器启动时运行的命令。

Dockerfile中可以有多个ENTRYPOINT指令，但只有最后一个生效。CMD或docker run之后的参数会被当做参数传递给ENTRYPOINT。

## RUN、CMD、ENTRYPOINT的使用

#### Shell 格式
```bash
<instruction> <command>
```

#### Exec
```bash
<instruction> ["executable", "param1", "param2", ...]
```

### RUN

RUN 在当前镜像的顶部执行命令，并通过创建新的镜像层。Dockerfile 中常常包含多个 RUN 指令。

RUN 有两种格式：
> Shell 格式：RUN

> Exec 格式：RUN ["executable", "param1", "param2"]

### CMD

CMD 指令允许用户指定容器的默认执行的命令。

此命令会在容器启动且docker run没有指定其他命令时运行。

如 docker run指定了其他命令，CMD指定的默认命令将被忽略。

如果Dockerfile中有多个CMD指令，只有最后一个CMD有效。

CMD 有三种格式：

* Exec 格式：CMD ["executable","param1","param2"],这是 CMD 的推荐格式。

* CMD ["param1","param2"] 为 ENTRYPOINT 提供额外的参数，此时 ENTRYPOINT 必须使用 Exec 格式。

* Shell 格式：CMD command param1 param2

> 注：第二种格式 CMD ["param1","param2"] 要与 Exec 格式 的 ENTRYPOINT 指令配合使用，其用途是为 ENTRYPOINT 设置默认的参数。我们将在后面讨论 ENTRYPOINT 时举例说明。

### ENTRYPOINT

ENTRYPOINT 指令可让容器以应用程序或者服务的形式运行。

ENTRYPOINT 看上去与 CMD 很像，它们都可以指定要执行的命令及其参数。不同的地方在于 ENTRYPOINT 不会被忽略，一定会被执行，即使运行 docker run 时指定了其他命令。

ENTRYPOINT 有两种格式：

* Exec 格式：ENTRYPOINT ["executable", "param1", "param2"] 这是 ENTRYPOINT 的推荐格式。

* Shell 格式：ENTRYPOINT command param1 param2

在为ENTRYPOINT选择格式时必须小心，因为这两种格式的效果差别很大。

##### ENTRYPOINT Exec格式

ENTRYPOINT的Exec格式用于设置要执行的命令及其参数，同时可通过 CMD 提供额外的参数。

ENTRYPOINT中的参数始终会被使用，而CMD的额外参数可以在容器启动时动态替换掉。

##### ENTRYPOINT Shell格式

ENTRYPOINT 的 Shell 格式会忽略任何 CMD 或 docker run 提供的参数。

### 最佳实践

* 使用 RUN 指令安装应用和软件包，构建镜像。

* 如果 Docker 镜像的用途是运行应用程序或服务，比如运行一个 MySQL，应该优先使用 Exec 格式的 ENTRYPOINT 指令。CMD 可为 ENTRYPOINT 提供额外的默认参数，同时可利用 docker run 命令行替换默认参数。

* 如果想为容器设置默认的启动命令，可使用 CMD 指令。用户可在 docker run 命令行中替换此默认命令。