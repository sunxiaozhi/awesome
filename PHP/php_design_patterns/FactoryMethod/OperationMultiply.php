<?php
/**
 * Created by PhpStorm.
 * 乘法类
 * User: sunxiaozhi
 * Date: 2018/3/13
 * Time: 16:38
 */
include_once 'Operation.php';

class OperationMultiply extends Operation
{
    public function getValue($num1, $num2)
    {
        return $num1 * $num2;
    }
}