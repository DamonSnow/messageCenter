<?php
/**
 * Created by PhpStorm.
 * User: Zby
 * Date: 2017/5/2
 * Time: 8:48
 */

namespace App;


use Illuminate\Database\Eloquent\Model;

class Group extends Model{
    protected $table = 'main_group';
    protected $primaryKey = 'id';

//    protected function getDateFormat()
//    {
//        return time();
//    }
//    protected function asDateTime($value)
//    {
//        return $value;
//    }
    public $timestamps = false;
}
