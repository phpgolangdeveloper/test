<?php

$typeId = $_GET['typeId'] ?: 8;

/***
 * 查找父级
 * @param int $typeId 具体要查的那条数据
 因为到一次一次去调用，等到女士的时候，方法执行完了 $v['id'] == $typeId 也就是女士的，然后就输出
完了之后他就会再返回上一次调用，上一次调用是服装
 */
function getTypeData($typeId)
{
    $array = array(
        array('id' => 1, 'pid' => 0, 'name' => '女士'),// 顶级
        array('id' => 2, 'pid' => 1, 'name' => '服装'),
        array('id' => 3, 'pid' => 2, 'name' => '针织衫'),
        array('id' => 4, 'pid' => 0, 'name' => '男士'),
        array('id' => 5, 'pid' => 1, 'name' => '鞋履'),
        array('id' => 6, 'pid' => 2, 'name' => '运动鞋'),
        array('id' => 7, 'pid' => 3, 'name' => '篮球鞋'),
        array('id' => 8, 'pid' => 7, 'name' => 'aa'),
    );
    foreach ($array as $k => $v){
        if ($v['id'] == $typeId){
            echo ($v['name']) . '->';
            getTypeData($v['pid']);//  等待调用结果
        }
    }
}
getTypeData($typeId);





// function cliRedis()
// {
//     $redis = new Redis();
//     $redis->connect('127.0.0.1',6379);
//     $redis->auth(123456);
// //    $bool = $redis->set('1',1);


//     $redis->rpush('lpush',1,2,3);

// //    var_dump();
// }
// cliRedis();