<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Comment;
use App\Http\Model\Links;
use App\Http\Model\Navs;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\View;

class IndexController extends CommonController
{
//  前台首页
    public function index(){

        //查询推荐博文
        $data['Artcom']=(new Article)->getartcom();
        //查询博文目录
        $data['category']=(new Category)->getcateall();
        //查询热点博文
        $data['Arthot']=(new Article)->getarthot();
        //查询友情链接
        $data['links']=(new Links)->getlinkall();

        return view('home.index',compact('data'));

    }


//前台列表
    public function cate($cate_id){
       //查询指定分类下的文章
       $arts= (new Article)->assginArt($cate_id);
       //查询分类名称
       $cate=(new Category)->assignCate($cate_id);
       //查询所有标签
       $childcate=(new Category)->childcate($cate_id);

       foreach($childcate as $k => $v){
          $childcate[$k]['count'] = Article::where('cate_id',$v['cate_id'])->count();
       }

       $catename=$cate['cate_name'];
        return view('home.cate',compact('arts','catename','childcate'));

    }

//前台详情
    public function news($art_id){

        $art= (new Article)->getartfirst($art_id);
//        //相关文章(读相关分类的)
        $data=Article::where('cate_id',$art->cate_id)->orderBy('art_id','desc')->take(6)->get();
//        //查看次数自增
        Article::where('art_id',$art_id)->increment('art_view');
// 调取文章评论信息
        $coms= (new Comment)->getcomall($art_id,5);

        return view('home.new',compact('art','data','coms'));
}
//

//博文搜索
    public function search(){
        //接收数据
        $input=Input::except('_token');
        //关键词
        $keywords=$input['keywords'];
        $arts=(new Article)->SearchArt($keywords,8);

        return view('home.search',compact('arts','keywords'));

    }

//文章评论
    public function comment(){
        //接收数据
        $input=Input::except('_token');
        $input['ip']=$_SERVER["REMOTE_ADDR"];
        $input['add_time']=time();
        $res= Comment::create($input);
        if($res){
            Article::where('art_id',$input['art_id'])->increment('com_view');
            return back()->with('success','文章评论发表成功');
        }else{
            return back()->with('error','文章评论发表失败,请稍后重试!');
        }

    }


}//class out
