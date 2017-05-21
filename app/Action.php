<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * since: 2017/4/29 20:41
 */
namespace App;
use Illuminate\Database\Eloquent\Model;

class Action extends Model{
    protected $table = 'action';
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
