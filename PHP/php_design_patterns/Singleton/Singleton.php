<?php
/**
 * Created by PhpStorm.
 *
 * User: sunxiaozhi
 * Date: 2018/3/13
 * Time: 13:44
 */

/**
 * 设计模式之单例模式
 * $_instance必须声明为静态的私有变量
 * 构造函数必须声明为私有,防止外部程序new类从而失去单例模式的意义
 * getInstance()方法必须设置为公有的,必须调用此方法以返回实例的一个引用
 * ::操作符只能访问静态变量和静态函数
 * new对象都会消耗内存
 * 使用场景:最常用的地方是数据库连接。
 * 使用单例模式生成一个对象后，该对象可以被其它众多对象所使用。
 */
class Singleton
{
    //保存例实例在此属性中
    /**
     * @var Singleton reference to singleton instance
     */
    private static $_instance;

    /**
     * 构造函数私有，不允许在外部实例化
     *
     */
    private function __construct()
    {
        echo '我被实例化了！' . '<br>';
    }

    /**
     * 通过延迟加载（用到时才加载）获取实例
     *
     * @return self
     */
    public static function getInstance()
    {
        var_dump(isset(self::$_instance));

        if (!isset(self::$_instance)) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * 防止对象实例被克隆
     *
     * @return void
     */
    private function __clone()
    {
        trigger_error('Clone is not allow', E_USER_ERROR);
    }

    /**
     * 防止被反序列化
     *
     * @return void
     */
    private function __wakeup()
    {
    }

    function test()
    {
        echo("test" . "<br>");
    }
}

//这个写法会出错，因为构造方法被声明为private
//$test = new Singleton;

// 下面将得到Example类的单例对象
$test = Singleton::getInstance();
$test = Singleton::getInstance();
$test->test();

// 复制对象将导致一个E_USER_ERROR.
//$test_clone = clone $test;