@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;查看文章评论消息
    </div>
    <!--面包屑导航 结束-->

	<!--结果集标题与导航组件 开始-->
	<div class="result_wrap">
        <div class="result_title">
            <h3>查看文章评论管理消息</h3>
        </div>
    </div>
    <!--结果集标题与导航组件 结束-->
    
    <div class="result_wrap">
            <table class="add_tab">
                <tbody>
                    <tr>
                        <th>所属文章：</th>
                        <td>
                            <input type="text"  readonly="readonly"  value="{{$com->art_title}}">
                        </td>
                    </tr>
                    <tr>
                        <th>昵称：</th>
                        <td>
                            <input type="text"  readonly="readonly"  value="{{$com->com_nikename}}">
                        </td>
                    </tr>
                    <tr>
                        <th>联系方式：</th>
                        <td>
                            <input type="text" class="lg"   readonly="readonly"  value="{{$com->com_link}}">
                        </td>
                    </tr>
                    <tr>
                        <th>ip地址：</th>
                        <td>
                            <input type="text" class="lg"  readonly="readonly"  value="{{$com->ip}}">
                        </td>
                    </tr>
                    <tr>
                        <th>联系方式：</th>
                        <td>
                            <input type="text" class="lg" name="cate_title"  readonly="readonly"  value="{{$com->com_link}}">
                        </td>
                    </tr>
                    <tr>
                        <th>消息内容</th>
                        <td>
                            <textarea name="cate_keywords" readonly="readonly" >{{$com->com_content}}</textarea>
                        </td>
                    </tr>
                    <tr>
                        <th>发送时间：</th>
                        <td>
                            <input type="text" class="lg" name="cate_title"  readonly="readonly"  value="{{date('Y-m-d H:i:s',$com->add_time) }}">
                        </td>
                    </tr>
                    <tr>
                        <th></th>
                        <td>
                            <input type="button" class="back" onclick="history.go(-1)" value="返回">
                        </td>
                    </tr>
                </tbody>
            </table>
    </div>
@endsection
