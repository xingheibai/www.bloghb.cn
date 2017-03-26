<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;

class Category extends Model
{
    //表名默认为Users 修改为user
    protected $table='category';
    //设置主键
    protected $primaryKey='cate_id';
    //关掉默认添加时间属性
    public $timestamps=false;
    //guarded 不能填充的字段 等于空 就是都能填充 框架的保护措施之一
    protected $guarded=[];

    //后台查询所有数据
    public function tree($limit=false){
        //调用处理分类方法
        if($limit){
            $cate=$this->select(DB::raw('*,concat(cate_path,cate_id) as paths'))->orderby('paths')->paginate(8);
        }else{
            $cate=$this->select(DB::raw('*,concat(cate_path,cate_id) as paths'))->orderby('paths')->get(8);
        }

        ///处理分类格式
        foreach ($cate as $key => $value) {
            //拆分path中的元素
            $tmp = explode(',',$value['cate_path']);
            //统计数组的元素个数
            $counts=count($tmp)-2;
            //添加分割符给分类名称
            $cate[$key]['cate_name']=str_repeat('|---',$counts).$value['cate_name'];
        }

     return $cate;
    }

    //查询所有分类
    public function getcateall(){
        $cache_status= Config::get('web.cache_status');
       //判断缓存是否开启
       if($cache_status){
           if(Cache::get('cates')){
               $cates=Cache::get('cates');
           }else{
               $cates = $this->orderBy('cate_order','asc')->select('cate_id','cate_name')->take(8)->get();
                Cache::add('cates',$cates,1140);
           }
       }else{
            $cates = $this->orderBy('cate_order','asc')->select('cate_id','cate_name')->take(8)->get();
        }

        return $cates;

    }


    //获取指定分类下所有的子分类
    public function childcate($pid){
        $cache_status= Config::get('web.cache_status');
        if($cache_status){
            $catekey='childcate'.$pid;
            if(Cache::get($catekey)){
                $childcate=Cache::get($catekey);
            }else{
                $childcate= $this->where('cate_pid',$pid)->get();
                if(empty($childcate->count())){
                    $childcate= $this->where('cate_id',$pid)->get();
                }
                Cache::add($catekey,$childcate,1140);

            }
        }else{
            $childcate= $this->where('cate_path','like','%'.$pid.'%')->get();
            if(empty($childcate->count())){
                $childcate= $this->where('cate_id',$pid)->get();
            }
        }

        return $childcate;
    }

    //获取顶级分类
    public function topcate(){
        $cache_status= Config::get('web.cache_status');
        if($cache_status){

            if(Cache::get('topcate')){
                $topcate=Cache::get('topcate');
            }else{
                $topcate= $this->where('cate_pid','0')->get();
                Cache::add('topcate',$topcate,1140);
            }
        }else{
            $topcate= $this->where('cate_pid','0')->get();
        }

        return $topcate;
    }

    

    //查询指定分类
    public function assignCate($cate_id){
        $cache_status= Config::get('web.cache_status');
        if($cache_status){
            $catekey='Cate'.$cate_id;
            if(Cache::get($catekey)){
                $cate=Cache::get($catekey);
            }else{
                $cate= $this->where('cate_id',$cate_id)->first();
                Cache::add($catekey,$cate,1140);
            }
        }else{
            $cate= $this->where('cate_id',$cate_id)->first();
        }

        return $cate;


    }

    //处理分类函数
        //参数:
            //$data 分类数组集
            //$filed_name 数组中分类名称
            //$filed_id 数组中分类id名称
            //$file_pid 数组中父级分类id名称
            //$pid 自定义父id
        public function getTree($data,$filed_name,$filed_id='id',$filed_pid='pid',$pid=0){
            $arr=array();
            foreach($data as $k=>$v){
                //顶级分类
                if($v->$filed_pid==$pid){
                    $data[$k]['_'.$filed_name]=$data[$k][$filed_name];
                    $arr[]=$data[$k];
                    foreach($data as $m=>$n){
                        if($n->$filed_pid == $v->$filed_id ){
                            $data[$m]['_'.$filed_name]='|--'.$data[$m][$filed_name];
                            $arr[]=$data[$m];
                        }
                    }
                }
            }
            return $arr;
        }

}
