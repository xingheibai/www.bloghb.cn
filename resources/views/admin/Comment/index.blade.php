@extends('layouts.admin')
@section('content')
    <!--面包屑导航 开始-->
    <div class="crumb_warp">
        <!--<i class="fa fa-bell"></i> 欢迎使用登陆网站后台，建站的首选工具。-->
        <i class="fa fa-home"></i> <a href="{{url('admin/info')}}">首页</a> &raquo; 文章评论消息
    </div>
    <!--搜索结果页面 列表 开始-->
    <form action="#" method="post">
        <div class="result_wrap">
            <div class="result_title">
                <h3>消息管理</h3>
             </div>
            <!--快捷导航 结束-->
        </div>

        <div class="result_wrap">
            <div class="result_content">
                <table class="list_tab">
                    <tr>
                        <th class="tc">消息ID</th>
                        <th>所属文章</th>
                        <th>发送人昵称</th>
                        <th>消息内容</th>
                        <th>状态</th>
                        <th>操作</th>
                    </tr>
                    @foreach($coms as $v)
                    <tr>
                        <td class="tc">{{$v->com_id}}</td>
                        <td class="tc">{{$v->art_title}}</td>
                        <td>
                            <a href="#">{{$v->com_nikename}}</a>
                        </td>
                        <td>{{$v->com_content}}</td>
                        <td>
                            @if($v->com_status == 1)
                               未读
                            @elseif($v->com_status == 2)
                                已读
                            @else
                                锁定
                            @endif
                        </td>
                        <td>
                            <a href="{{url('admin/art/comment/show/'.$v->com_id.'')}}">查看</a>
                            <a href="javascript:;" onclick="DelCate({{$v->com_id}})">删除</a>
                        </td>
                    </tr>
                     @endforeach
                </table>
                {{--分页--}}
                {{--<div class="page_nav">--}}
                    {{--<div>--}}
                        {{--<a class="first" href="/wysls/index.php/Admin/Tag/index/p/1.html">第一页</a>--}}
                        {{--<a class="prev" href="/wysls/index.php/Admin/Tag/index/p/7.html">上一页</a>--}}
                        {{--<a class="num" href="/wysls/index.php/Admin/Tag/index/p/6.html">6</a>--}}
                        {{--<a class="num" href="/wysls/index.php/Admin/Tag/index/p/7.html">7</a>--}}
                        {{--<span class="current">8</span>--}}
                        {{--<a class="num" href="/wysls/index.php/Admin/Tag/index/p/9.html">9</a>--}}
                        {{--<a class="num" href="/wysls/index.php/Admin/Tag/index/p/10.html">10</a>--}}
                        {{--<a class="next" href="/wysls/index.php/Admin/Tag/index/p/9.html">下一页</a>--}}
                        {{--<a class="end" href="/wysls/index.php/Admin/Tag/index/p/11.html">最后一页</a>--}}
                        {{--<span class="rows">11 条记录</span>--}}

                    {{--</div>--}}
                {{--</div>--}}

                <div class="page_list">
                    <ul>
                        {{$coms->links()}}
                    </ul>
                </div>
            </div>
        </div>
    </form>
    <!--搜索结果页面 列表 结束-->
    <script>
        //删除评论
        function DelCate(com_id){
            //询问框
            layer.confirm('您确定要删除这条评论吗？', {
                btn: ['确定','取消'] //按钮
            }, function(){
                //layer.msg('的确很重要', {icon: 1}); 确定走这个区间
                $.post("{{url('admin/art/comment/delete')}}",{'com_id':com_id,'_token':'{{csrf_token()}}'},function(data){
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
    </script>

@endsection
