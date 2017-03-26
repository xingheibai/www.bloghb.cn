@extends('layouts.home')
@section('content')
<section class="container">
<div class="content-wrap">
<div class="content">
  <header class="article-header">
	<h1 class="article-title"><a href="#" title="{{$art['art_title']}}" >{{$art['art_title']}}</a></h1>
	<div class="article-meta">
		<span class="item article-meta-time">
	  		<time class="time" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="发表时间：{{date('Y-m-d',$art['art_time'])}}">
				<i class="glyphicon glyphicon-time"></i>{{date('Y-m-d',$art['art_time'])}}
			</time>
	  </span>
		<span class="item article-meta-source" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="来源：{{$art['art_editor']}}">
			<i class="glyphicon glyphicon-globe"></i> {{$art['art_editor']}}
		</span>
		<span class="item article-meta-category" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="{{$art['cate_name']}}">
			<i class="glyphicon glyphicon-list"></i>
			<a href="{{url('/cate/'.$art['cate_id'].'')}}" title="{{$art['cate_name']}}" >{{$art['cate_name']}}</a>
		</span>
		<span class="item article-meta-views" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="浏览量：{{$art['art_view']}}">
			<i class="glyphicon glyphicon-eye-open"></i>{{$art['art_view']}}
		</span>
		<span class="item article-meta-comment" data-toggle="tooltip" data-placement="bottom" title="" data-original-title="评论量">
			<i class="glyphicon glyphicon-comment"></i> 4
		</span>
	</div>
  </header>
  <article class="article-content">
	  {!! $art['art_content'] !!}
	<div class="bdsharebuttonbox"><a href="#" class="bds_more" data-cmd="more"></a><a href="#" class="bds_qzone" data-cmd="qzone" title="分享到QQ空间"></a><a href="#" class="bds_tsina" data-cmd="tsina" title="分享到新浪微博"></a><a href="#" class="bds_tqq" data-cmd="tqq" title="分享到腾讯微博"></a><a href="#" class="bds_weixin" data-cmd="weixin" title="分享到微信"></a><a href="#" class="bds_tieba" data-cmd="tieba" title="分享到百度贴吧"></a><a href="#" class="bds_sqq" data-cmd="sqq" title="分享到QQ好友"></a></div>

		  <script>                  window._bd_share_config = { "common": { "bdSnsKey": {}, "bdText": "", "bdMini": "2", "bdMiniList": false, "bdPic": "", "bdStyle": "1", "bdSize": "32" }, "share": {} }; with (document) 0[(getElementsByTagName('head')[0] || body).appendChild(createElement('script')).src = 'http://bdimg.share.baidu.com/static/api/js/share.js?v=0.js?cdnversion=' + ~(-new Date() / 36e5)];</script>
  </article>
  <div class="article-tags">
	  标签：<a href="{{url('/cate/'.$art['cate_id'].'')}}" rel="tag" >{{$art['cate_name']}}</a>
	  {{--<a href="#list/3/" rel="tag" >木庄网络博客</a>--}}
	  {{--<a href="#list/4/" rel="tag" >独立博客</a>--}}
	  {{--<a href="#list/5/" rel="tag" >修复优化</a>--}}
	</div>
  <div class="relates">
	<div class="title">
	  <h3>相关推荐</h3>
	</div>
	<ul>
		@foreach($data as $k => $v)
	  <li><a href="{{url('/art/'.$v['art_id'].'')}}" title="{{$v['art_title']}}" >{{$v['art_title']}}</a></li>
		@endforeach
	</ul>
  </div>
  <div class="title" id="comment">
	<h3>评论</h3>
  </div>
  <div id="respond">
		<form id="comment-form" name="comment-form" action="{{url('/art/comment')}}" method="POST">
			{{csrf_field()}}
			<input type="hidden" name="art_id" value="{{$art['art_id']}}" >
			<div class="comment">
				<input name="com_nikename" id="" class="form-control" size="22" placeholder="您的昵称（必填）" maxlength="15" autocomplete="off" tabindex="1" type="text">
				<input name="com_link" id="" class="form-control" size="22" placeholder="您的网址或邮箱（非必填）" maxlength="58" autocomplete="off" tabindex="2" type="text">
				<div class="comment-box">
					<textarea placeholder="您的评论或留言（必填）" name="com_content" id="comment-textarea" cols="100%" rows="3" tabindex="3"></textarea>
					<div class="comment-ctrl">
						<div class="comment-prompt" style="display: none;"> <i class="fa fa-spin fa-circle-o-notch"></i> <span class="comment-prompt-text">评论正在提交中...请稍后</span> </div>
						@if(Session::has('success'))
							<div class="comment-success" style="display: block;"> <i class="fa fa-check"></i> <span class="comment-prompt-text">{{Session::get('success')}}</span> </div>
						@endif

							<button  id="comment-submit" onclick="return comment()" tabindex="4">评论</button>
					</div>

				</div>
			</div>
		</form>
	</div>
	<script>
		function comment(){
			var nikename= $("input[name=com_nikename]").val();
			var content=$("#comment-textarea").val();
			if(nikename == ''){
				alert('昵称不能为空!');
				return false;
			}else if(content == ''){
				alert('评论内容不能为空!');
				return false;
			}else{
				return true;
			}

		}
	</script>
  <div id="postcomments">
	<ol id="comment_list" class="commentlist">
	@if($coms->count())
		@foreach($coms as $k => $v)
		<li class="comment-content"><span class="comment-f">{{$k+1}}楼</span><div class="comment-main"><p><a class="address" href="#" rel="nofollow" target="_blank">{{$v['com_nikename']}}</a><span class="time">({{date('Y/m/d H:i:s',$v['add_time'])}})</span><br>{{$v['com_content']}}</p></div></li>
		@endforeach
	 @else
			<li class="comment-content">
				<b>暂无评论信息!</b>
			</li>
	@endif
  </div>
	<nav class="pagination">
		<ul>
			{{$coms->links()}}
		</ul>
	</nav>
</div>
</div>
<aside class="sidebar">
<div class="fixed">
  <div class="widget widget-tabs">
	<ul class="nav nav-tabs" role="tablist">
	  <li role="presentation" class="active"><a href="#notice" aria-controls="notice" role="tab" data-toggle="tab" draggable="false">统计信息</a></li>
	  <li role="presentation"><a href="#contact" aria-controls="contact" role="tab" data-toggle="tab" draggable="false">联系站长</a></li>
	</ul>
	<div class="tab-content">
	  <div role="tabpanel" class="tab-pane contact active" id="notice">
		  <h2>博文总数:
			  {{$Artcount}}篇
		  </h2>
		  <h2>网站运行:
		  <span id="sitetime">88天 </span></h2>
	  </div>
		<div role="tabpanel" class="tab-pane contact" id="contact">
		  <h2>QQ:
			  <a href="" target="_blank" rel="nofollow" data-toggle="tooltip" data-placement="bottom" title="" draggable="false" data-original-title="QQ:577211782">577211782</a>
		  </h2>
		  <h2>Email:
		  <a href="mailto:577211782@qq.com" target="_blank" data-toggle="tooltip" rel="nofollow" data-placement="bottom" title="" draggable="false" data-original-title="Email:577211782@qq.com">577211782@qq.com</a></h2>
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
	  <h3>最新评论文章</h3>
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
