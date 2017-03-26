<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;

use App\Http\Requests;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\Input;
use App\Http\Model\User;
//引入第三方验证码类
include('resources/org/code/Code.class.php');

class LoginController extends CommonController{
//登录界面
    public function login(){   
//        input获取传递过来的值
            if($input= Input::all()){
//        实例化验证码对象 需要加\
                $code = new \Code;
//        获取验证码 小技巧:将用户输入的验证码统一转为大写 这样避免大小写不一致 验证码报错
               $_code=$code->get();
                if(strtoupper($input['code'])!=$_code){
//                    back()函数 返回到前一个请求页面 with() 向页面传递参数 把值存到session
                    return back()->with('msg','验证码错误!');
                }
                //获取User表里的一条数据
                $user=User::first();
                //对用户密码进行判断
                    if($user->user_name != $input['user_name'] || Crypt::decrypt($user->user_pass)!=$input['user_pass']){
                        return back()->with('msg','用户名或密码错误!');
                    }
                session(['user'=>$user]);
                    return redirect('admin/index');
                }else{
                session(['user'=>null]);
                //映射到前台页面
                return view('admin.login');
            }

 
//        映射到前台页面
                return view('admin.login');
    }

//验证码
    public function code(){
//      实例化验证码对象 需要加\
        $code = new \Code;
//      生成验证码
        $code->make();
    }

//退出
    public function quit(){
        session(['user'=>null]);

        return redirect('admin/login');
    }




//    public function crypt(){
//        $str='1234556';
//        //使用crypt加密 Crypt::encrypt();
//       echo  Crypt::encrypt($str);
//        //进行解密 Crypt:decrypt();
//        echo '<hr>';
//        $str1='eyJpdiI6IkZ4K0t5SmtoZjhOZGxFRnZOTjZBU0E9PSIsInZhbHVlIjoiVERFK2JDSHFCa3FIcVhSOEViNGlndz09IiwibWFjIjoiN2QxZDVlYWVjOGYwNzViODdlZDQ4ZTIyMmJiOTNmY2VhOGE2ZjU5YWFhMzc5YjQ0NTNmMTcyNWNlMTAxOGM5OCJ9';
//        echo Crypt::decrypt($str1);
//    }


}