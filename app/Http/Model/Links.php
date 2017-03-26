<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class Links extends Model
{
    //表名默认为links  链接model
    protected $table='links';
    //设置主键
    protected $primaryKey='link_id';
    //关掉默认添加时间属性
    public $timestamps=false;
    //guarded 不能填充的字段 等于空 就是都能填充 框架的保护措施之一
    protected $guarded=[];

    //查询所有友情链接
    public function  getlinkall(){
        $cache_status= Config::get('web.cache_status');
        //判断缓存是否开启
        if($cache_status){
            if(Cache::get('linkall')){
                $links=Cache::get('linkall');
            }else{
                $links= $this->orderBy('link_order','asc')->take(6)->get();
                Cache::add('linkall',$links,5);
            }
        }else{
            $links= $this->orderBy('link_order','asc')->take(6)->get();
        }
        return $links;
    }



}
