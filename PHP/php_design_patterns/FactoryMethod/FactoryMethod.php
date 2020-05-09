<?php
/**
 *
 * User: sunxiaozhi
 * Date: 2020/5/7 14:31
 */
include_once __DIR__ . '/FactoryMethodInterface.php';
include_once __DIR__ .'/OperationAdd.php';

class FactoryMethod implements FactoryMethodInterface
{
    public function createOperation()
    {
        return new OperationAdd();
    }

}