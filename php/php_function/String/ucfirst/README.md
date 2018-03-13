## ucfirst

(PHP 4, PHP 5, PHP 7)

ucfirst — 将字符串的首字母转换为大写

### 说明

string ucfirst ( string $str ) 将 str 的首字符（如果首字符是字母）转换为大写字母，并返回这个字符串。

注意字母的定义取决于当前区域设定。例如，在默认的 “C” 区域，字符 umlaut-a（ä）将不会被转换。

### 参数

```
str
    输入字符串。
```

### 返回值

返回结果字符串。