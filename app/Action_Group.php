<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * since: 2017/5/2 22:29
 */
namespace App;
use Illuminate\Database\Eloquent\Model;

class Action_Group extends Model{
    protected $table = 'action_group';
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
