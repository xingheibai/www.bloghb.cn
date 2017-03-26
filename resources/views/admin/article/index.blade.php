@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo;文章管理
    </div>
    <!--面包屑导航 结束-->


    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>文章管理</h3>
            </div>
            <!--快捷导航 开始-->
            <div class="result_content">
                <div class="short_wrap">
                    <a href="{{url('admin/article/create')}}"><i class="fa fa-plus"></i>新增文章</a>
                    <a href="{{url('admin/article')}}"><i class="fa fa-recycle"></i>全部文章</a>
                </div>
            </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">ID</th>
                        <th>标题</th>
                        <th>点击</th>
                        <th>编辑</th>
                        <th>发布时间</th>
                        <th>操作</th>
                    </tr>
                    @foreach($data as $v)
                    <tr>
                        <td class="tc">{{$v->art_id}}</td>
                        <td>
                            {{$v->art_title}}
                            @if($v->art_status == 2)
                            <b style="color:deepskyblue">[推荐文章]</b>
                            @endif
                        </td>
                        <td>{{$v->art_view}}次</td>
                        <td>{{$v->art_editor}}</td>
                        <td>{{date('Y-m-d H:i:s',$v->art_time)}}</td>
                        <td>
                            <a href="{{url('admin/article/'.$v->art_id.'/edit')}}">编辑</a>
                            <a href="javascript:;" onclick="DelCate({{$v->art_id}})">删除</a>
                            {{--<a href="{{url('admin/art/commend/'.$v->art_id.'')}}">推荐</a>--}}
                            <a href="javascript:;" onclick="ArtCommend({{$v->art_id}})">[推荐文章]</a>
                        </td>
                    </tr>
                    @endforeach
                </table>
                <div class="page_list">
                    {{--<ul>--}}
                        {{--<li class="disabled"><a href="#">&laquo;</a></li>--}}
                        {{--<li class="active"><a href="#">1</a></li>--}}
                        {{--<li><a href="#">2</a></li>--}}
                        {{--<li><a href="#">3</a></li>--}}
                        {{--<li><a href="#">4</a></li>--}}
                        {{--<li><a href="#">5</a></li>--}}
                        {{--<li><a href="#">&raquo;</a></li>--}}
                    {{--</ul>--}}

                    {{$data->links()}}
                </div>
                <style>
                    .result_content ul li span {
                        font-size: 15px;
                        padding: 6px 12px;
                    }
                </style>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
<script>
//删除文章
    function DelCate(art_id){
//询问框
        layer.confirm('您确定要删除这篇文章吗？', {
            btn: ['确定','取消'] //按钮
        }, function(){
            //确定走这个区间
            $.post("{{url('admin/article/')}}/"+art_id,{'_method':'delete','_token':'{{csrf_token()}}'},function(data){
                if(data.status==0){
                //刷新当前页面
                    location.href=location.href;
                    layer.msg(data.msg, {icon: 6});
                }else{
                    layer.msg(data.msg, {icon: 5});
                }
            })
        }, function(){
            //取消走这个区间
        });
    }
//设置推荐文章
   function ArtCommend(art_id){
        //layer询问框
       layer.confirm('您确定要设置为推荐文章吗？', {
           btn: ['确定','取消'] //按钮
       }, function(){
           //确定走这个区间
           $.get("{{url('admin/art/commend/')}}/"+art_id,{'key':'2016789'},function(data){
               if(data.status==0){
                   //刷新当前页面
                   layer.msg(data.msg, {icon: 6});
                   location.href=location.href;
               }else{
                   layer.msg(data.msg, {icon: 5});
               }
           })
       }, function(){
           //取消走这个区间
       });
   }
</script>


@endsection

