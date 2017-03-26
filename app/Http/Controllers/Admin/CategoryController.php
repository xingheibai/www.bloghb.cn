<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Category;
use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;

class CategoryController extends CommonController
{
  //资源路由
  //get.admin/category   全部分类列表
  public function index(){
    //获取结果
    $categorys=(new Category)->tree(true);
     return view('admin.category.index')->with('data',$categorys);
  }


//get.admin/category/create 添加分类
  public function create(){
     $data= (new Category)->tree();

     return view('admin.category.add',compact('data'));
  }


//post.admin/category  执行分类添加
    public function store(){
        //except() 方法 过滤值 除了XX之外都要
        $input=Input::except('_token');
        //验证类Validator
        //常用验证规则:
        //required不能为空
        //between方法:字符多少到多少之间
        //confirmed方法:需要把确认密码字段变成password_confirmation
        $rules=[
            'cate_name'=>'required',
        ];

        //自定义错误
        $message=[
            'cate_name.required'=>'分类名称不能为空!',
        ];
        //对接收过来的参数进行验证 make (传递要验证的信息 ,验证规则 ,自定义错误)
        $validator= Validator::make($input,$rules,$message);
        //获取结果判断 passes 结果
        if($validator->passes()){
            //判断是否是顶级分类 pid=0
            if($input['cate_pid']==0){
                $input['cate_path']='0,';
            }else{
               //如果不是顶级分类 查询
                $p_cate=Category::where('cate_id',$input['cate_pid'])->select('cate_path')->first();
                $input['cate_path']=$p_cate['cate_path'].$input['cate_pid'].',';
            }

//           执行添加
            $res=Category::create($input);
            if($res){
                return redirect('admin/category');
            }else{
                return back()->with('errors','数据填充失败错误,请稍后重试!');
            }
        }else{
            //打印错误 errors()  获取所有错误  all(); 框架自带函数withError() 自动就将错误信息返回
            return back()->withErrors($validator);
        }

    }

//get.admin/category/{category}/edit  更新分类
    public function edit($cate_id){
        $field=Category::find($cate_id);
        $data= (new Category) -> tree();
        return view('admin.category.edit',compact('field','data'));
    }


//put.admin/category/{category}/update 执行更新分类
    public function update($cate_id){
       $input= Input::all();
       $input=Input::except('_token','_method');
        //判断是否是顶级分类 pid=0
        if($input['cate_pid']==0){
            $input['cate_path']='0,';
        }else{
            //如果不是顶级分类 查询
            $p_cate=Category::where('cate_id',$input['cate_pid'])->select('cate_path')->first();
            $input['cate_path']=$p_cate['cate_path'].$input['cate_pid'].',';
        }

       $res=Category::where('cate_id',$cate_id)->update($input);
        if($res){
            return redirect('admin/category');
        }else{
            return back()->with('errors','数据更新失败错误,请稍后重试!');
        }

    }




//get.admin/category/{category} 显示单个分类信息
    public function show(){

    }

//delete.admin/category/{category} 删除
    public function destroy($cate_id){
        //执行删除
        $res=Category::where('cate_id',$cate_id)->delete();
            //当删除顶级分类其余分类变为顶级分类
             Category::where('cate_pid',$cate_id)->update(['cate_pid'=>0]);
            if($res){
                $data=[
                    'status'=>0,
                    'msg'=>'分类删除成功!',
                ];
            }else{
                $data=[
                    'status'=>1,
                    'msg'=>'分类删除失败 请稍后重试!',
                ];
            }

        return $data;

    }




//ajax
    public function changeOrder(){
//        获取ajax接收过来的值
        $input=Input::all();
        $cate=Category::find($input['cate_id']);
        $cate->cate_order=$input['cate_order'];
        //执行更新
        $res=$cate->update();
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
