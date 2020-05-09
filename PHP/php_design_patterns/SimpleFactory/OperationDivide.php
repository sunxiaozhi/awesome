<?php
/**
 * Created by PhpStorm.
 * 除法类
 * User: sunxiaozhi
 * Date: 2018/3/13
 * Time: 16:38
 */
include_once 'Operation.php';

class OperationDivide extends Operation
{
    public function getValue($num1, $num2)
    {
        try {
            if ($num2 == 0) {
                throw new Exception("除数不能为0");
            } else {
                return $num1 / $num2;
            }
        } catch (Exception $e) {
            die("错误信息：" . $e->getMessage());
        }
    }
}