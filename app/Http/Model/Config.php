<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;

class Config extends Model
{
    //表名默认为Users 修改为user
    protected $table='config';
    //设置主键
    protected $primaryKey='conf_id';
    //关掉默认添加时间属性
    public $timestamps=false;
    //guarded 不能填充的字段 等于空 就是都能填充 框架的保护措施之一
    protected $guarded=[];

}
