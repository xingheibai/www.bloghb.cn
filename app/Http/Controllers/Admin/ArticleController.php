<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Article;
use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class ArticleController extends CommonController{
//get.admin/article   全部文章列表
    public function index(){
        //paginate分页方法
       $data= Article::orderBy('art_id','desc')->paginate(10);
        //links调用分页信息
//        dd($data->links());

        return view('admin.article.index',compact('data'));
    }


//get.admin/article/create 添加文章
    public function create(){
    //查询分类信息
     $data=(new Category)->tree();
     return view('admin.article.add',compact('data'));
    }

    //post.admin/article  执行文章添加
    public function store(){
        //获取from表单提交信息
        $data=Input::except('_token');
        //存入当前时间
        $data['art_time']=time();
        //验证类Validator
        //常用验证规则:
        //required不能为空
        //between方法:字符多少到多少之间
        //confirmed方法:需要把确认密码字段变成password_confirmation
        $rules=[
            'art_title'=>'required',
            'art_content'=>'required',
            'art_thumb'=>'required',

        ];

        //自定义错误
        $message=[
            'art_title.required'=>'文章名称不能为空!',
            'art_content.required'=>'文章内容不能为空!',
            'art_thumb.required'=>'文章缩略图不能为空!',
        ];
        //对接收过来的参数进行验证 make (传递要验证的信息 ,验证规则 ,自定义错误)
        $validator= Validator::make($data,$rules,$message);

        if($validator->passes()){
            //查询cate_path
            $Cate=Category::where('cate_id',$data['cate_id'])->select('cate_path','cate_id')->first();
            $data['cate_path']=$Cate['cate_path'].$Cate['cate_id'];
            //上传图片
            $data['art_thumb']=$this->upload('art_thumb');
            //执行添加
            $res=Article::create($data);
            //判断结果
            if($res){
                return redirect('admin/article');
            }else{
                return back()->with('errors','数据填充失败错误,请稍后重试!');
            }
        }else{
            //打印错误 errors()  获取所有错误  all(); 框架自带函数withError() 自动就将错误信息返回
            return back()->withErrors($validator);
        }

    }



//get.admin/article/{article}/edit  编辑文章
    public function edit($art_id){
        $data=(new Category)->tree();
        //查询文章信息
        $filed=Article::find($art_id);
        //查询分类信息
        return view('admin.article.edit',compact('data','filed'));

    }

//put.admin/category/{category}/update 执行文章
    public function update($art_id){
        $input=Input::except('_token','_method');
        //判断是否上传图片
        if(isset($input['art_thumb'])){
            $input['art_thumb']=$this->upload('art_thumb');
            //取出以前图片
            $old=Article::where('art_id',$art_id)->select('art_thumb')->first();
           //拼接以前图片路径
            $oldpath=base_path().$old['art_thumb'];
            @unlink($oldpath);
        }
        //查询cate_path
        $Cate=Category::where('cate_id',$input['cate_id'])->select('cate_path','cate_id')->first();
        $input['cate_path']=$Cate['cate_path'].$Cate['cate_id'];
        $res=Article::where('art_id',$art_id)->update($input);
        if($res){
            return redirect('admin/article');
        }else{
            return back()->with('errors','数据更新失败错误,请稍后重试!');
        }
    }

//delete.admin/category/{category} 删除
    public function destroy($art_id){
        //执行删除
        $res=Article::where('art_id',$art_id)->delete();
        //判断删除
        if($res){
            $data=[
                'status'=>0,
                'msg'=>'文章删除成功!',
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'文章删除失败 请稍后重试!',
            ];
        }

        return $data;
    }
//文章推荐
    public function commend($art_id){
        //查询其他文章是否设置为文章推荐
        $art=Article::where('art_status',2)->first();

        if($art){
            //将其他文章取消
            Article::where('art_id',$art['art_id'])->update(['art_status' => 1]);
        }
        //设置文章为推荐文章
        $res=Article::where('art_id',$art_id)->update(['art_status' => 2]);

        if($res){
            $data=[
                'status'=>0,
                'msg'=>'设置文章推荐成功!',
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'设置文章推荐失败 请稍后重试!',
            ];
        }
        return $data;
    }



}
