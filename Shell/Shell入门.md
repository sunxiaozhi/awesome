#! 告诉系统其后路径所指定的程序即是解释此脚本文件的 Shell 程序。

```bash
#!/bin/bash
```

新建一个文件 test.sh，扩展名为 sh（sh代表shell），扩展名并不影响脚本执行。

```bash
#!/bin/bash
echo 'test'
```

### 作为可执行程序
chmod +x ./test.sh  #使脚本具有执行权限
./test.sh  #执行脚本

### 作为解释器参数
```bash
/bin/bash test.sh
```

Shell 文件包含

```bash
. filename  #注意点号(.)和文件名中间有一空格
或
source filename
```