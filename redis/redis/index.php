<?php

include "RedisOption.php";

$config = array(
    'host' => '192.168.20.55',
    'port' => '6379',
    'auth' => '123',
);

$attr = array(
    'db_id' => 6,
);

$redis1 = RedisOption::getInstance($config, $attr);

$d = $redis1->set( "testKey2" , "Hello Redis"); //设置测试key

var_dump($d);

echo $redis1->get("testKey") . '<br>';//输出value

$redis2 = RedisOption::getInstance($config, $attr);

$redis2->set( "testKey4" , "Hello Redis"); //设置测试key

echo $redis2->get("testKey") . '<br>';//输出value

$redis2->hSet('h', 'key1', 'hello');
$redis2->hSet('h', 'key2', 'hello2');
echo $redis2->hGet('h', 'key1');
