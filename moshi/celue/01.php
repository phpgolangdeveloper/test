<?php
// 策略模式和工厂模式取别
// 个人认为只有一点吧，策略模式是映射对象，工厂是根据不同情况直接的返回对象


interface Math
{
    public function calc($op1, $op2);
}

class MathAdd implements Math
{
    public function calc($op1, $op2)
    {
        // TODO: Implement calc() method.
        return $op1 + $op2;
    }
}

class MathSub implements Math
{
    public function calc($op1, $op2)
    {
        // TODO: Implement calc() method.
        return $op1 - $op2;

    }
}

class MathMul implements Math
{
    public function calc($op1, $op2)
    {
        // TODO: Implement calc() method.
        return $op1 * $op2;
    }
}

class Mathdiv implements Math
{
    public function calc($op1, $op2)
    {
        // TODO: Implement calc() method.
        return $op1 / $op2;
    }
}

// 封装1个虚拟计算机
class CMath
{
    protected $calc = null;

    public function __construct($type)
    {
        $calc = 'Math' . $type;
        $this->calc = new $calc();
    }

    public function calc($op1, $op2)
    {
        return $this->calc->calc($op1, $op2);
    }

}

$type = $_POST['op'] ?: 'Mul';
$op1 = $_POST['op1'] ?: 5;
$op2 = $_POST['op2'] ?: 10;
$cmath = new CMath($type);
$res = $cmath->calc($op1, $op2);
var_dump($res);