<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;

class Article extends Model
{
    //表名默认为Users 修改为user
    protected $table='article';
    //设置主键
    protected $primaryKey='art_id';
    //关掉默认添加时间属性
    public $timestamps=false;
    //guarded 不能填充的字段 等于空 就是都能填充 框架的保护措施之一
    protected $guarded=[];

//推荐博文
    public function getartcom(){
        $cache_status= Config::get('web.cache_status');
        //判断缓存是否开启
        if($cache_status){
            if(Cache::get('artcom')){
                $art=Cache::get('artcom');
            }else{
                $art= $this->where('art_status','2')->first();
                Cache::add('artcom',$art,1140);
            }
        }else{
            $art= $this->where('art_status','2')->first();
        }

        return $art;
    }

//热点博文
    public function  getarthot(){
        $cache_status= Config::get('web.cache_status');
        //判断缓存是否开启
        if($cache_status){
            if(Cache::get('arthot')){
                $art=Cache::get('arthot');
            }else{
                $art= $this->leftJoin('category','article.cate_id','=','category.cate_id')->select('article.*','category.cate_name')->orderBy('art_view','desc')->paginate(10);
                Cache::add('arthot',$art,1140);
            }
        }else{
            $art= $this->leftJoin('category','article.cate_id','=','category.cate_id')->select('article.*','category.cate_name')->orderBy('art_view','desc')->paginate(10);
        }
        return $art;
    }
//博文数量
    public function artcount(){
            $artcount= $this->count();
        return $artcount;
    }

//最新博文
    public function getartnew(){
        $cache_status= Config::get('web.cache_status');
        //判断缓存是否开启
        if($cache_status){
            if(Cache::get('artnew')){
                $art=Cache::get('artnew');
            }else{
                $art= $this->orderBy('art_time','desc')->take(8)->get();
                Cache::add('artnew',$art,5);
            }
        }else{
            $art= $this->orderBy('art_time','desc')->take(8)->get();
        }
        return $art;
    }

//查询指定分类下所有博文
    public function assginArt($cate_id){

        $cache_status= Config::get('web.cache_status');
        //判断缓存是否开启
        if($cache_status){

            $catename='Art'.$cate_id;

            if(Cache::get($catename)){
                $art=Cache::get($catename);
            }else{
                $art= $this->leftJoin('category','article.cate_id','=','category.cate_id')->select('article.*','category.cate_name')->where('article.cate_path', 'like', '%'.$cate_id.'%')->orderBy('art_time','desc')->paginate(8);
                Cache::add($catename,$art,10);
            }
        }else{
            $art= $this->leftJoin('category','article.cate_id','=','category.cate_id')->select('article.*','category.cate_name')->where('article.cate_path', 'like', '%'.$cate_id.'%')->orderBy('art_time','desc')->paginate(8);
        }
        return $art;
    }

//查询指定波纹
    public function getartfirst($art_id){
        $cache_status= Config::get('web.cache_status');
        //判断缓存是否开启
        if($cache_status){
            $firstkey='Artfirst'.$art_id;
            if(Cache::get($firstkey)){
                $art=Cache::get($firstkey);
            }else{
                $art= $this->Join('category','article.cate_id','=','category.cate_id')->where('art_id',$art_id)->first();

                Cache::add($firstkey,$art,1440);
            }
        }else{
            $art=$this->Join('category','article.cate_id','=','category.cate_id')->where('art_id',$art_id)->first();
        }
        return $art;

    }

//搜索博文
    public function SearchArt($keywords,$limit){
        $cache_status= Config::get('web.cache_status');
        //判断缓存是否开启
        if($cache_status){
            $SearchArt='SearchArt'.$keywords;
            if(Cache::get($SearchArt)){
                $art=Cache::get($SearchArt);
            }else{
                $art= $this->Join('category','article.cate_id','=','category.cate_id')->where('article.art_title', 'like', '%'.$keywords.'%')->paginate($limit);
                Cache::add($SearchArt,$art,1440);
            }
        }else{
            $art= $this->Join('category','article.cate_id','=','category.cate_id')->where('article.art_title', 'like', '%'.$keywords.'%')->paginate($limit);
        }
        return $art;


    }

} //class over
