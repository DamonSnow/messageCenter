<?php

namespace App;


use Illuminate\Database\Eloquent\Model;

class User extends Model{
    protected $table = 'user';
    protected $primaryKey = 'serial';
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
