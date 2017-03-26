<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class Comment extends Model
{
    //表名默认为Users 修改为user
    protected $table='comment';
    //设置主键
    protected $primaryKey='com_id';
    //关掉默认添加时间属性
    public $timestamps=false;
    //guarded 不能填充的字段 等于空 就是都能填充 框架的保护措施之一
    protected $guarded=[];

 //查询指定文章下的所有评论
        public function getcomall($art_id,$page){
            $cache_status= Config::get('web.cache_status');
            $com_key='getcom_all'.$art_id;
            //判断缓存是否开启
            if($cache_status){
                if(Cache::get($com_key)){
                    $coms=Cache::get($com_key);
                }else{
                    $coms = $this->orderBy('add_time','asc')->where('art_id',$art_id)->paginate($page);
                    Cache::add($com_key,$coms,5);
                }
            }else{
                $coms = $this->orderBy('add_time','asc')->where('art_id',$art_id)->paginate($page);
            }

            return $coms;
        }


}//class out
