<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Input;

class CommonController extends Controller
{
    //此控制器用于继承和公用性方法
    //图片上传
    //$filename   上传文件名
    //$dir  指定上传目录(非必须)
    public function upload($filename,$dir=''){
       if($filename){
           $file=Input::file($filename);
       }else{
           $file= Input::file('Filedata');
       }
//        $dirpath=$dir ? '/uploads/pic/'.$dir.'/':'/uploads/pic/'.date('Ymd',time()).'/';
//        dd(base_path().$dirpath);
        if($file -> isValid()){
            //检验一下上传的文件是否有效.
            $realPath = $file -> getRealPath();    //这个表示的是缓存在tmp文件夹下的文件的绝对路径
            $entension = $file -> getClientOriginalExtension(); //上传文件的后缀.
            $newName=date('YmdHis').mt_rand(100,999).'.'.$entension; //拼接上传后的文件名
            //移动文件并且重命名(执行上传)
            $dirpath=$dir ? '/uploads/pic/'.$dir.'/':'/uploads/pic/'.date('Ymd',time()).'/';
            $path = $file ->move(base_path().$dirpath,$newName);
            $filepath=$dirpath.$newName;
        }
        return $filepath;
    }

    /*
     *
     * 删除指定目录中的所有目录及文件（或者指定文件）
     * 可扩展增加一些选项（如是否删除原目录等）
     * 删除文件敏感操作谨慎使用
     * @param $dir 目录路径
     * @param array  $file_type指定文件类型
     */
    function delFile($dir,$file_type='') {
        if(is_dir($dir)){
            $files = scandir($dir);//打开目录 //列出目录中的所有文件并去掉 . 和 ..
            foreach($files as $filename){
                if($filename!='.' && $filename!='..'){
                    if(!is_dir($dir.'/'.$filename)){
                        if(empty($file_type)){
                            unlink($dir.'/'.$filename);
                        }else{
                            if(is_array($file_type)){
                                //正则匹配指定文件
                                if(preg_match($file_type[0],$filename)){
                                    unlink($dir.'/'.$filename);
                                }
                            }else{
                                //指定包含某些字符串的文件
                                if(false!=stristr($filename,$file_type)){
                                    unlink($dir.'/'.$filename);
                                }
                            }
                        }
                    }else{
                        delFile($dir.'/'.$filename);
                        rmdir($dir.'/'.$filename);
                    }
                }
            }
        }else{
            if(file_exists($dir)) unlink($dir);
        }

        return true;
    }



}
