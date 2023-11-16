<?php
/**
 * Created by PhpStorm.
 * 加法类
 * User: sunxiaozhi
 * Date: 2018/3/13
 * Time: 16:38
 */
include_once 'Operation.php';

class OperationAdd extends Operation
{
    public function getValue($num1, $num2)
    {
        return $num1 + $num2;
    }
}