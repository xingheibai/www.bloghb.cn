@extends('layouts.home')
@section('content')
<section class="container">
<div class="content-wrap">
<div class="content">
  <div id="focusslide" class="carousel slide" data-ride="carousel">
	<ol class="carousel-indicators">
	  <li data-target="#focusslide" data-slide-to="0" class="active"></li>
	  <li data-target="#focusslide" data-slide-to="1"></li>
	</ol>
	<div class="carousel-inner" role="listbox">
	  <div class="item active">
	  <a href="#" target="_blank" title="木庄网络博客源码" >
	  <img src="{{url('resources/views/home/style/images/201610181557196870.jpg')}}" alt="木庄网络博客源码" class="img-responsive"></a>
	  </div>
	  <div class="item">
	  <a href="#" target="_blank" title="专业网站建设" >
	  <img src="{{url('resources/views/home/style/images/201610181557196870.jpg')}}" alt="专业网站建设" class="img-responsive"></a>
	  </div>
	</div>
	<a class="left carousel-control" href="#focusslide" role="button" data-slide="prev" rel="nofollow"> <span class="glyphicon glyphicon-chevron-left" aria-hidden="true"></span> <span class="sr-only">上一个</span> </a> <a class="right carousel-control" href="#focusslide" role="button" data-slide="next" rel="nofollow"> <span class="glyphicon glyphicon-chevron-right" aria-hidden="true"></span> <span class="sr-only">下一个</span> </a> </div>
  <article class="excerpt-minic excerpt-minic-index">
		<h2><span class="red">【推荐】</span><a target="_blank" href="{{url('/art/'.$data['Artcom']['art_id'].'')}}" title="{{$data['Artcom']['art_title']}}" >{{$data['Artcom']['art_title']}}</a>
		</h2>
		<p class="note">{{$data['Artcom']['art_description']}}</p>
	</article>
  <div class="title">
	<h3>热点博文</h3>
	<div class="more">
		@foreach($data['category'] as $k => $v)
			<a href="{{url('/cate/'.$v['cate_id'].'')}}" title="{{$v['cate_name']}}" >{{$v['cate_name']}}</a>
		@endforeach
		</div>
  </div>
	@foreach($data['Arthot'] as $k => $v)
  <article class="excerpt excerpt-1" style="">
  <a class="focus" href="{{url('/art/'.$v['art_id'].'')}}" title="{{$v['art_title']}}" target="_blank" ><img class="thumb" data-original="{{$v['art_thumb']}}" src="{{$v['art_thumb']}}" alt="{{$v['art_thumb']}}"  style="display: inline;"></a>
		<header><a class="cat" href="{{url('/cate/'.$v['cate_id'].'')}}" title="{{$v['cate_name']}}" >{{$v['cate_name']}}<i></i></a>
			<h2><a href="{{url('/art/'.$v['art_id'].'')}}" title="{{$v['art_title']}}" target="_blank" >{{$v['art_title']}}</a>
			</h2>
		</header>
		<p class="meta">
			<time class="time"><i class="glyphicon glyphicon-time"></i> {{date('Y-m-d',$v{'art_time'})}}</time>
			<span class="views"><i class="glyphicon glyphicon-eye-open"></i>{{$v['art_view']}}</span> <a class="comment" href="##comment" title="评论" target="_blank" ><i class="glyphicon glyphicon-comment"></i> {{$v['com_view']}}</a>
		</p>
		<p class="note">{{$v['art_description']}}</p>
	</article>
	@endforeach
  <nav class="pagination" style="display: block;">
	<ul>
	{{--  <li class="prev-page"></li>
	  <li class="active"><span>1</span></li>
	  <li><a href="?page=2">2</a></li>
	  <li class="next-page"><a href="?page=2">下一页</a></li>
	  <li><span>共 2 页</span></li>--}}
		{{$data['Arthot']->links()}}
	</ul>
  </nav>
</div>
</div>
<aside class="sidebar">
<div class="fixed">
  <div class="widget widget-tabs">
	<ul class="nav nav-tabs" role="tablist">
	  <li role="presentation" class="active"><a href="#notice" aria-controls="notice" role="tab" data-toggle="tab" >统计信息</a></li>
	  <li role="presentation"><a href="#contact" aria-controls="contact" role="tab" data-toggle="tab" >联系站长</a></li>
	</ul>
	<div class="tab-content">
	  <div role="tabpanel" class="tab-pane contact active" id="notice">
		<h2>博文总数:
			  {{$Artcount}}篇
		  </h2>
		  <h2>网站运行:
		  <span id="sitetime">27天 </span></h2>
	  </div>
		<div role="tabpanel" class="tab-pane contact" id="contact">
		  <h2>QQ:949442334
			  <a href="" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="bottom" title=""  data-original-title="QQ:"></a>
		  </h2>
		  <h2>Email:949442334@qq.com
		  <a href="#" target="_blank" data-toggle="tooltip" rel="nofollow" data-placement="bottom" title=""  data-original-title="#"></a></h2>
	  </div>
	</div>
  </div>
  <div class="widget widget_search">
	<form class="navbar-form" action="{{url('/search')}}" method="get">
		{{csrf_field()}}
	  <div class="input-group">
		<input type="text" name="keywords" id="keyword" class="form-control" size="35" placeholder="请输入关键字" maxlength="15" autocomplete="off">
		<span class="input-group-btn">
		<button class="btn btn-default btn-search" onclick="return checkout()" type="submit" >搜索</button>
		</span>
	  </div>
	</form>
  </div>
</div>
<div class="widget widget_hot">
	  <h3>最新博文</h3>
	  <ul>
		  @foreach($Artnew as $k=>$v)
			<li>
				<a title="{{$v['art_title']}}" href="{{url('/art/'.$v['art_id'].'')}}" >
					<span class="thumbnail">
						<img class="thumb" data-original="{{$v['art_thumb']}}" src="{{url($v['art_thumb'])}}" alt="{{$v['art_keywords']}}"  style="display: block;">
					</span>
					<span class="text">{{$v['art_title']}}</span>
					<span class="muted"><i class="glyphicon glyphicon-time"></i>{{date('Y-m-d',$v['art_time'])}}</span>
					<span class="muted"><i class="glyphicon glyphicon-eye-open"></i>{{$v['art_view']}}</span>
				</a>
			</li>
		  @endforeach
	  </ul>
 </div>
 <div class="widget widget_sentence">    
	<a href="#" target="_blank" rel="nofollow" title="专业网站建设" >
	<img style="width: 100%" src="{{url('resources/views/home/style/images/201610241224221511.jpg')}}" alt="专业网站建设" ></a>
 </div>
 <div class="widget widget_sentence">    
	<a href="#" target="_blank" rel="nofollow" title="MZ-NetBlog主题" >
	<img style="width: 100%" src="{{url('resources/views/home/style/images/ad.jpg')}}" alt="MZ-NetBlog主题" ></a>
 </div>
<div class="widget widget_sentence">
  <h3>友情链接</h3>
  <div class="widget-sentence-link">
	  @foreach($data['links'] as $k=>$v)
	 <a href="{{$v['link_url']}}" title="{{$v['link_name']}}" target="_blank" >{{$v['link_name']}}</a>&nbsp;&nbsp;&nbsp;
	  @endforeach
  </div>
</div>
</aside>
</section>
@endsection


