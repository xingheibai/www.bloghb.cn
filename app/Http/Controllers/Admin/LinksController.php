<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Links;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class LinksController extends CommonController
{
    //链接列表  //get.admin/links
    public function index(){
      $data=Links::orderBy('link_order','asc')->get();
     return view('admin.links.index',compact('data'));
    }


    //get.admin/links/create 添加链接
    public function create(){
        return view('admin.links.add');
    }


    //post.admin/links  执行链接添加
    public function store(){
        //过滤token
        $input=Input::except('_token');
        //验证类Validator
        //常用验证规则:
        $rules=[
            'link_name'=>'required',
            'link_title'=>'required',
            'link_url'=>'required',
        ];

        //自定义错误
        $message=[
            'link_name.required'=>'链接名称不能为空!',
            'link_title.required'=>'链接标题不能为空!',
            'link_url.required'=>'链接网址不能为空!',
        ];
        $validator=Validator::make($input,$rules,$message);
        //获取结果判断 passes 结果
        if($validator->passes()){
//           执行添加
            $res=Links::create($input);
            if($res){
                return redirect('admin/links');
            }else{
                return back()->with('errors','数据填充失败错误,请稍后重试!');
            }
        }else{
            //打印错误 errors()  获取所有错误  all(); 框架自带函数withError() 自动就将错误信息返回
            return back()->withErrors($validator);
        }


    }


    //get.admin/category/{category}/edit  更新分类
    public function edit($link_id){
        $field=Links::find($link_id);
        return view('admin.links.edit',compact('field'));
    }


//put.admin/category/{category}/update 执行更新分类
    public function update($link_id){
        $input=Input::except('_token','_method');
        //验证类Validator
        //常用验证规则:
        $rules=[
            'link_name'=>'required',
            'link_title'=>'required',
            'link_url'=>'required',
        ];

        //自定义错误
        $message=[
            'link_name.required'=>'链接名称不能为空!',
            'link_title.required'=>'链接标题不能为空!',
            'link_url.required'=>'链接网址不能为空!',
        ];
        $validator=Validator::make($input,$rules,$message);
        if($validator->passes()){
            $res=Links::where('link_id',$link_id)->update($input);
            if($res){
                return redirect('admin/links');
            }else{
                return back()->with('errors','数据更新失败错误,请稍后重试!');
            }

        }else{
            //打印错误 errors()  获取所有错误  all(); 框架自带函数withError() 自动就将错误信息返回
            return back()->withErrors($validator);
        }


    }




//get.admin/category/{category} 显示单个分类信息
    public function show(){

    }

//delete.admin/category/{category} 删除
    public function destroy($link_id){
        //执行删除
        $res=Links::where('link_id',$link_id)->delete();

        if($res){
            $data=[
                'status'=>0,
                'msg'=>'链接删除成功!',
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'链接删除失败 请稍后重试!',
            ];
        }

        return $data;

    }




    //ajax
    public function changeOrder(){
    //获取ajax接收过来的值
        $input=Input::all();
        $links=Links::find($input['link_id']);
        $links->link_order=$input['link_order'];
        //执行更新
        $res=$links->update();
        if($res){
            $data=[
                'status'=>0,
                'msg'=>'分类排序更新成功!',
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'分类排序更新失败,请稍后重试!',
            ];
        }

        return $data;

    }


}
