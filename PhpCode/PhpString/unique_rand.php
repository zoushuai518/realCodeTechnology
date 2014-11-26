<?php
//zs测试可用

/**
 * array unique_rand( int $min, int $max, int $num )
 * 生成一定数量的不重复随机数
 * $min 和 $max: 指定随机数的范围
 * $num: 指定生成数量
 */
function unique_rand($min, $max, $num) {
    $count = 0;
    $return = array();
    while ($count < $num) {
        $return[] = mt_rand($min, $max);
        $return = array_flip(array_flip($return));
        $count = count($return);
    }
    shuffle($return);
    return $return;
}

$arr = unique_rand(1, 25, 16);
sort($arr);

$result = '';
for($i=0; $i < count($arr);$i++)
{
    $result .= $arr[$i].',';
}
$result = substr($result, 0, -1);
echo $result;

// 程序运行如下：
// 2,3,4,6,7,8,9,10,11,12,13,16,20,21,22,24

// 补充几点说明：
// 生成随机数时用了 mt_rand() 函数。这个函数生成随机数的平均速度要比 rand() 快四倍。
// 去除数组中的重复值时用了“翻翻法”，就是用 array_flip() 把数组的 key 和 value 交换两次。这种做法比用 array_unique() 快得多。
// 返回数组前，先使用 shuffle() 为数组赋予新的键名，保证键名是 0-n 连续的数字。如果不进行此步骤，可能在删除重复值时造成键名不连续，给遍历带来麻烦。
?>
