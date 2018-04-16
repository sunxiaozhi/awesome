<?php
/**
 * redis支持五种数据类型，list、hash、string、set、zset
 */
include "RedisOption.php";

/**
 * 打印函数
 * @param $var
 */
function p($var)
{
    if (is_bool($var)) {
        var_dump($var);
    } else if (is_null($var)) {
        var_dump(NULL);
    } else {
        echo "<pre style='position:relative;z-index:1000;padding:10px;border-radius:5px;background:#F5F5F5;border:1px solid #aaa;font-size:14px;line-height:18px;opacity:0.9;'>" . print_r($var, true) . "</pre>";
    }
}

//配置信息
$config = array(
    'host' => '192.168.0.51',
    'port' => '6379',
    'auth' => '123456',
);

$attr = array(
    'db_id' => 0,
);

$redis_one = RedisOption::getInstance($config, $attr);

/*测试string类型*/
$redis_one->set( "testKey" , "Hello Redis"); //设置测试key
p($redis_one->get("testKey"));//输出value

/*测试list类型*/

/*测试hash类型*/
$redis_one->hSet('hash', 'key1', 'hello1');
$redis_one->hSet('hash', 'key2', 'hello2');
p($redis_one->hGet('hash', 'key1'));
p($redis_one->hGet('hash', 'key2'));
/*测试set类型*/

/*测试zset类型*/

$redis_two = RedisOption::getInstance($config, $attr);
//$redis_two->flushDB();
p($redis_two->ttl('hash'));
p($redis_two->keys('*'));
p($redis_two->dbSize());