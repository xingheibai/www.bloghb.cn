<!doctype html>
<html lang="zh-CN">
<head>
    <meta charset="utf-8">
    <meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{Config::get('web.web_title')}}</title>
    <meta name="keywords" content="{{Config::get('web.keywords')}}">
    <meta name="description" content="{{Config::get('web.web_description')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/resources/views/home/style/css/bootstrap.min.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/resources/views/home/style/css/nprogress.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('/resources/views/home/style/css/style.css')}}">
    <link rel="stylesheet" type="text/css" href="{{asset('resources/views/home/style/css/font-awesome.min.css')}}">
    <link rel="apple-touch-icon-precomposed" href="{{url('resources/views/home/style/images/icon.png')}}">
    <link rel="shortcut icon" href="{{url('resources/views/home/style/images/favicon.ico')}}">
    <script src="{{asset('/resources/views/home/style/js/jquery-2.1.4.min.js')}}"></script>
    <script src="{{asset('/resources/views/home/style/js/nprogress.js')}}"></script>
    <script src="{{asset('/resources/views/home/style/js/jquery.lazyload.min.js')}}"></script>
    <script type="text/javascript" src="{{asset('/resources/org/layer/layer.js')}}"></script>
    <!--[if gte IE 9]>
    <script src="{{asset('/resources/views/home/style/js/jquery-1.11.1.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/resources/views/home/style/js/html5shiv.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/resources/views/home/style/js/respond.min.js')}}" type="text/javascript"></script>
    <script src="{{asset('/resources/views/home/style/js/selectivizr-min.js')}}" type="text/javascript"></script>
    <![endif]-->
    <!--[if lt IE 9]>
    <script>window.location.href='upgrade-browser.html';</script>
    <![endif]-->
</head>
<body class="user-select">
<header class="header">
    <nav class="navbar navbar-default" id="navbar">
        <div class="container">
            <div class="header-topbar hidden-xs link-border">
                <ul class="site-nav topmenu">
                    <li><a href="#" >标签云</a></li>
                    <li><a href="#" rel="nofollow" >读者墙</a></li>
                    <li><a href="#" title="RSS订阅" >
                            <i class="fa fa-rss">
                            </i> RSS订阅
                        </a></li>
                </ul>
                勤记录 懂分享</div>
            <div class="navbar-header">
                <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#header-navbar" aria-expanded="false"> <span class="sr-only"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> <span class="icon-bar"></span> </button>
                <h1 class="logo hvr-bounce-in"><a href="{{url('/')}}" title="木庄网络博客"><img src="{{url(Config::get('web.web_logo'))}}" alt="木庄网络博客"></a></h1>
            </div>
            <div class="collapse navbar-collapse" id="header-navbar">
                <form class="navbar-form visible-xs" action="/Search" method="post">
                    <div class="input-group">
                        <input type="text" name="keyword" class="form-control" placeholder="请输入关键字" maxlength="20" autocomplete="off">
		<span class="input-group-btn">
		<button class="btn btn-default btn-search" name="search" type="submit">搜索</button>
		</span> </div>
                </form>
                <ul class="nav navbar-nav navbar-right">
                    <li><a title="首页" href="{{url('/')}}">首页</a></li>
                    @foreach($topcate as $k => $v)
                    <li><a title="{{$v['cate_name']}}" href="{{url('/cate/'.$v['cate_id'].'')}}">{{$v['cate_name']}}</a></li>
                    @endforeach
                </ul>
            </div>
        </div>
    </nav>
</header>
{{--内容--}}
    @yield('content')


{{--footer--}}
<footer class="footer">
    <div class="container">
        <p>{!! Config::get('web.copyright') !!}</p>
    </div>
    <div id="gotop"><a class="gotop"></a></div>
</footer>
<script src="{{asset('/resources/views/home/style/js/bootstrap.min.js')}}"></script>
<script src="{{asset('/resources/views/home/style/js/jquery.ias.js')}}"></script>
{{--<script src="{{asset('/resources/views/home/style/js/scripts.js')}}"></script>--}}
<script>
    function checkout(){
        var keywords =$("#keyword").val();
        if(keywords == ''){
            alert('请输入关键词!');
            return false;
        }else{
            return true;
        }
    }

</script>
@if (Session::get('success'))
    <script type="text/javascript">
        layer.msg('{{Session::get("success")}}', {time: 2000, icon:6});
    </script>
@endif
@if (Session::get('error'))
    <script type="text/javascript">
        layer.msg('{{Session::get("error")}}', {time: 2000, icon:5});
    </script>
@endif

</body>
</html>

