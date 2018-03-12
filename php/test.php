<?php
/**
 * Created by PhpStorm.
 *
 * User: sunhuanzhi
 * Date: 2018/3/12
 * Time: 14:06
 */
include "./arithmetic.php";
include "./function.php";

echo getRandom_one('number');
echo "<br>";
echo getRandom_two();
echo "<br>";
echo getDaysInMonth_one(3,2018);
echo "<br>";
echo getDaysInMonth_two(3,2018);

//echo formatTime('2018/3/12 14:8:48');
