<?php
/**
 * ucfirst的使用
 * User: sunxiaozhi
 * Date: 2018/3/13
 * Time: 10:44
 */

include '../../function.php';

$foo = 'hello world!';
$foo = ucfirst($foo);             // Hello world!

p($foo);

$bar = 'HELLO WORLD!';
$bar = ucfirst($bar);             // HELLO WORLD!

p($bar);

$bar = ucfirst(strtolower($bar)); // Hello world!    strtolower将字符全部转换为小写  strtoupper字符全部转换为大写

p($bar);
