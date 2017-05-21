<?php
/**
 * Created by PhpStorm.
 * User: Zby
 * Date: 2017/5/4
 * Time: 15:14
 */

namespace App;


/**判断两个数组是否完全相等
 * @param $key1 数组1
 * @param $key2 数组2
 * @return bool
 */
function judgeEqual($key1,$key2){
    if(array_diff($key1,$key2) || array_diff($key2,$key1)){
        return true;
    }else{
        return false;
    }
}