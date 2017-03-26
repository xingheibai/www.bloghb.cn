<?php

namespace App\Http\Controllers\Admin;


use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use App\Http\Model\User;
class IndexController extends CommonController{

   public function index(){
//测试数据库
//    $pdo = DB::connection()->getpdo();

      return view('admin.index');
   }

//子视图
    public function info(){
      return view('admin.info');
    }

//修改密码
   public function pass(){
       if($input=Input::all()){
//验证类Validator
//         验证规则
           $rules=[
//                密码不能为空 between方法:字符多少到多少之间 confirmed方法:需要在确认密码字段变成password_confirmation
                'password'=>'required|between:6,20|confirmed',
           ];

//         自定义错误
           $message=[
//               自定义错误
                'password.required'=>'新密码不能为空!',
                'password.between'=>'新密码必须在6-20位之间!',
                'password.confirmed'=>'新密码和确认密码不一致',
           ];
           //对接收过来的参数进行验证 make 1传递要验证的信息 2验证规则 3自定义错误
           $validator= Validator::make($input,$rules,$message);
           //获取结果判断 passes 结果
           if($validator->passes()){
                $user=User::first();
                $_password=Crypt::decrypt($user->user_pass);

               if($input['password_o']==$_password){
                    $user->user_pass=Crypt::encrypt($input['password']);
                    $user->update();
                   return back()->with('errors','密码修改成功!');
               }else{
                   return back()->with('errors','原密码错误!');
               }

           }else{
               //打印错误 errors()  获取所有错误  all(); 框架自带函数withError() 自动就将错误信息返回
               return back()->withErrors($validator);
           }


       }else{

           return view('admin.pass');
       }

   }

    //清除缓存
    public function cache(){
        //删除框架缓存
        //拼接缓存路径
        $path=base_path().'\storage\framework\views';
        $type='php';
        $res=$this->delFile($path,$type);
        //清除memcached缓存
        if(Config::get('web.cache_status')){
            Cache::flush();
        }
        
        //跳转回首页
        return redirect('admin/index');
    }





}
