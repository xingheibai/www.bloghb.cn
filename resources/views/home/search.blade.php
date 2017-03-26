@extends('layouts.home')
@section('content')
<section class="container">
<div class="content-wrap">
<div class="content">
  <div class="title">
	<h3 style="line-height: 1.3;">关键词: <b style="color:red;">{{$keywords}}</b> </h3>
  </div>
	@if($arts->count())
		@foreach($arts as $k=>$v)
	  <article class="excerpt excerpt-1"><a class="focus" href="{{url('/art/'.$v['art_id'].'')}}" title="{{$v['art_title']}}" target="_blank" ><img class="thumb" data-original="{{$v['art_thumb']}}" src="{{url($v['art_thumb'])}}" alt="{{$v['art_thumb']}}"  style="display: inline;"></a>
		<header><a class="cat" href="{{url('/cate/'.$v['cate_id'].'')}}" title="{{$v['cate_name']}}" >{{$v['cate_name']}}<i></i></a>
		  <h2><a href="{{url('/art/'.$v['art_id'].'')}}" title="{{$v['art_title']}}" target="_blank" >{{$v['art_title']}}</a></h2>
		</header>
		<p class="meta">
		  <time class="time"><i class="glyphicon glyphicon-time"></i> {{date('Y-m-d',$v['art_time'])}}</time>
		  <span class="views"><i class="glyphicon glyphicon-eye-open"></i> {{$v['art_view']}}</span> <a class="comment" href="##comment" title="评论" target="_blank" ><i class="glyphicon glyphicon-comment"></i> 4</a></p>
		<p class="note">{{$v['art_description']}}</p>
	  </article>
		@endforeach
	@else
		<b style="margin:100px 0px 0px 150px; float:left;">您好,暂时没有搜到关于 <em style="color:red;">{{$keywords}}</em> 相关的信息!</b>
	@endif
  <nav class="pagination">
	<ul>
	  {{--<li class="prev-page"></li>--}}
	  {{--<li class="active"><span>1</span></li>--}}
	  {{--<li><a href="?page=2">2</a></li>--}}
	  {{--<li class="next-page"><a href="?page=2">下一页</a></li>--}}
	  {{--<li><span>共 2 页</span></li>--}}
		{{$arts->links()}}
	</ul>
  </nav>
</div>
</div>
<aside class="sidebar">
<div class="fixed">
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
  {{--<div class="widget widget_sentence">--}}
	{{--<h3>标签云</h3>--}}
	{{--<div class="widget-sentence-content">--}}
		{{--<ul class="plinks ptags">--}}
			{{--@foreach($childcate as $k => $v)--}}
			{{--<li><a href="{{url('/cate/'.$v['cate_id'].'')}}" title="{{$v['cate_name']}}" draggable="false">{{$v['cate_name']}} <span class="badge">{{$v['count']}}</span></a></li>--}}
		    {{--@endforeach--}}
		{{--</ul>--}}
	{{--</div>--}}
  {{--</div>--}}
</div>
<div class="widget widget_hot">
	  <h3>最新博文</h3>
	  <ul>
		  @foreach($Artnew as $k=>$v)
			  <li>
				  <a title="{{$v['art_title']}}" href="{{url('/art/'.$v['art_id'].'')}}" >
					<span class="thumbnail">
						<img class="thumb" data-original="{{url($v['art_thumb'])}}" src="{{url($v['art_thumb'])}}" alt="{{$v['art_title']}}"  style="display: block;">
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

<a href="#" target="_blank" rel="nofollow" title="MZ-NetBlog主题" >
	<img style="width: 100%" src="{{url('resources/views/home/style/images/201610241224221511.jpg')}}" alt="MZ-NetBlog主题" ></a>

</div>
  <div class="widget widget_sentence">

<a href="#" target="_blank" rel="nofollow" title="专业网站建设" >
	<img style="width: 100%" src="{{url('resources/views/home/style/images/ad.jpg')}}" alt="专业网站建设" ></a>

</div>
</aside>
</section>
@endsection
