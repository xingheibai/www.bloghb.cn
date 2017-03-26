<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Comment;
use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommentController extends Controller
{
   //文章评论
    //列表
    public function index(){
        //获取所有评论
        $coms= Comment::leftJoin('article','article.art_id','=','comment.art_id')->select('comment.*','article.art_title')->orderBy('add_time','dasc')->paginate(10);

        return view('admin.Comment.index',compact('coms'));
    }

    //详情
    public function show($com_id){
        $com=Comment::leftJoin('article','article.art_id','=','comment.art_id')->select('comment.*','article.art_title')->where('com_id',$com_id)->orderBy('add_time','dasc')->first();
//        修改状态
        Comment::where('com_id',$com_id)->update(['com_status'=>2]);

        return view('admin.Comment.show',compact('com'));
    }

    //删除
    public function  delete(){
        $input=Input::except('_token');
        $com_id=$input['com_id'];
        $res =Comment::where('com_id',$com_id)->delete();
        if($res){
            $data=[
                'status'=>0,
                'msg'=>'评论删除成功!',
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'评论删除失败 请稍后重试!',
            ];
        }
        return $data;
    }



}//class out
