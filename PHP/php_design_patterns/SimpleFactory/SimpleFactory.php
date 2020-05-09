<?php
/**
 * Created by PhpStorm.
 *
 * User: sunxiaozhi
 * Date: 2018/3/13
 * Time: 16:55
 */
include_once 'OperationAdd.php';
include_once 'OperationSubtract.php';
include_once 'OperationMultiply.php';
include_once 'OperationDivide.php';
include_once 'OperationRemainder.php';

class SimpleFactory
{
    public static function createObj($operate)
    {
        try {
            switch ($operate) {
                case '+':
                    return new OperationAdd();
                    break;
                case '-':
                    return new OperationSubtract();
                    break;
                case '*':
                    return new OperationMultiply();
                    break;
                case '/':
                    return new OperationDivide();
                    break;
                case '%':
                    return new OperationRemainder();
                    break;
                default:
                    throw new Exception("方法不存在");
                    break;
            }
        } catch (Exception $e) {
            die("错误信息：" . $e->getMessage());
        }
    }
}

$num1 = 10;
$num2 = 3;
$operate = '/';

$test = SimpleFactory::createObj($operate);
echo $num1 . $operate . $num2 . '=' . $test->getValue($num1, $num2);

