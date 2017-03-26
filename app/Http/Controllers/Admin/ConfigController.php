<?php

namespace App\Http\Controllers\Admin;
use App\Http\Model\Config;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Http\Requests;
use Illuminate\Support\Facades\Input;

class configController extends CommonController{
    //配置项列表  //get.config/config
    public function index(){
        $data=Config::orderBy('conf_order','asc')->get();
//        遍历配置项类型
        foreach($data as $k=>$v){
            switch($v->field_type){
                case 'input':
                    $data[$k]->_html='<input type="text" class="lg" name="'.$v->conf_name.'" value="'.$v->conf_content.'">';
                    break;
                case 'textarea':
                    $data[$k]->_html='<textarea name="'.$v->conf_name.'" class="lg">'.$v->conf_content.'</textarea>';
                    break;
                case 'radio':
                    $arr=explode(',',$v->field_value);
                    $str='';
                    //遍历配置项单选类型值
                    foreach($arr as $m=>$n){
                        $r=explode('|',$n);
                        $c=$v->conf_content==$r[0]?'checked':'';
                       $str.='<input type="radio" name="'.$v->conf_name.'" value="'.$r[0].'" '.$c.' >'.$r[1].'　';
                    }
                    $data[$k]->_html=$str;
                    break;
                case 'file':
                    $data[$k]->_html='<input type="file" class="lg" name="'.$v->conf_name.'" style="float:left;margin-top: 10px;" >';
                    if ($v->conf_content){
                        $data[$k]->_html .='<img src="'.$v->conf_content.'" width="162px" height="42px"  style="float:left" >';
                    }
                    break;
                
            }
        }

        return view('admin.config.index',compact('data'));
    }


    //get.admin/config/create 添加配置项
    public function create(){
        return view('admin.config.add');
    }


    //post.admin/config  执行配置项添加
    public function store(){
        //过滤token
        $input=Input::except('_token');
        //验证类Validator
        //常用验证规则:
        $rules=[
            'conf_title'=>'required',
            'conf_name'=>'required',
            'field_type'=>'required',

        ];

        //自定义错误
        $message=[
            'conf_title.required'=>'配置项网址不能为空!',
            'conf_name.required'=>'配置项名称不能为空!',
            'field_type.required'=>'配置项类型不能为空!',

        ];
        $validator=Validator::make($input,$rules,$message);
        //获取结果判断 passes 结果
        if($validator->passes()){
//           执行添加
            $res=Config::create($input);
            if($res){
                $this->putFile(); //将配置文件导出
                return redirect('admin/config');
            }else{
                return back()->with('errors','数据填充失败错误,请稍后重试!');
            }
        }else{
            //打印错误 errors()  获取所有错误  all(); 框架自带函数withError() 自动就将错误信息返回
            return back()->withErrors($validator);
        }


    }


    //get.admin/category/{category}/edit  修改分类
    public function edit($conf_id){
        $field=Config::find($conf_id);

        return view('admin.config.edit',compact('field'));
    }


//put.admin/category/{category}/update 执行更新分类
    public function update($conf_id){
        $input=Input::except('_token','_method');

        //验证类Validator
        //常用验证规则:
        $rules=[
            'conf_title'=>'required',
            'conf_name'=>'required',
            'field_type'=>'required',
        ];

        //自定义错误
        $message=[
            'conf_title.required'=>'配置项网址不能为空!',
            'conf_name.required'=>'配置项名称不能为空!',
            'field_type.required'=>'配置项类型不能为空!',
        ];
        $validator=Validator::make($input,$rules,$message);
        if($validator->passes()){
            $res=Config::where('conf_id',$conf_id)->update($input);
            if($res){
                $this->putFile(); //将配置文件导出
                return redirect('admin/config');
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
    public function destroy($conf_id){
        //执行删除
        $res=Config::where('conf_id',$conf_id)->delete();

        if($res){
            $this->putFile(); //将配置文件导出
            $data=[
                'status'=>0,
                'msg'=>'配置项删除成功!',
            ];
        }else{
            $data=[
                'status'=>1,
                'msg'=>'配置项删除失败 请稍后重试!',
            ];
        }

        return $data;

    }



    //修改content值
    public function changecontent(){
        //过滤token
        $input=Input::except('_token');
        //判断是否上传网站logo
        if(isset($input['web_logo'])){
              //调用上传函数
            $input['web_logo']=$this->upload('web_logo');
        }

        foreach($input as $k=>$v){
            Config::where('conf_name',$k)->update(['conf_content'=>$v]);
        }

        $this->putFile(); //将配置文件导出
        return back()->with('errors','配置项更新成功,请稍后重试');

    }


    //导出配置项文件
    public function putFile(){
        //读取配置文件
//       echo  \Illuminate\Support\Facades\Config::get('web.web_count');
        //从数据库读取配置项
        $config=Config::pluck('conf_content','conf_name')->all();
        //base_path(); 项目根目录
        $path=base_path().'/config/web.php'; //路径
        //将数组转为字符串 var_export true不输出
        $str= '<?php return '.var_export($config,true).';';
//        将配置写入文件
        file_put_contents($path,$str);

    }




    //ajax
    public function changeOrder(){
        //获取ajax接收过来的值
        $input=Input::all();
        $config=Config::find($input['conf_id']);
        $config->conf_order=$input['conf_order'];
        //执行更新
        $res=$config->update();
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
