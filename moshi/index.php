<?php

// 单例模式
class sigle
{

    // 3 getIns先判断实例
    protected static $ins = null;

    // 1 封锁 new 操作
    // 4 方法前加上final则方法不能被覆盖，类前加final则不能被继承
    // 第五步主要是防止别的类重写__construct，覆盖了，那这里的__construct就无效了，所以要加final
    final protected function __construct()
    {

    }

    // 2 留一个接口来new对象
    public static function getIns()
    {
        if (self::$ins === null) {
            self::$ins = new self();
        }
        return self::$ins;
    }

    // 4 封锁clone,不然外部调用时候再使用clone方法，又会产生新的对象了
    final protected function __clone()
    {

    }


}


/*
	注意
	1 两个对象是一个的时候才会全等 ===
*/

$s1 = sigle::getIns();
$s2 = sigle::getIns();

if ($s1 === $s2) {
    echo '是一个对象';
} else {
    echo '不是一个对象';
}