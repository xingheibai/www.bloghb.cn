<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class User extends Model
{
    //表名默认为Users 修改为user
    protected $table='user';
    //设置主键
    protected $primaryKey='user_id';
    //关掉默认添加时间属性
    public $timestamps=false;

    public function Userlist(){

        if(Cache::get('userlist')){
            $userlist='已经存入缓存当中了';
        }else{
            $userlist=$this->paginate(15);
            Cache::add('userlist',$userlist,1);
        }

        return $userlist;
    }
}
