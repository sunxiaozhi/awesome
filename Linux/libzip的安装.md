# libzip的安装

```bash
wget https://libzip.org/download/libzip-1.5.2.tar.gz

tar -zxf libzip-1.5.2.tar.gz

cd libzip-1.5.2

mkdir build

cd build

cmake ..        （#注意：cmake后面有两个小数点）

make -j4

make test

make instal
```
