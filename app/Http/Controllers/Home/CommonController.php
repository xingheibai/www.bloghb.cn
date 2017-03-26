<?php

namespace App\Http\Controllers\Home;

use App\Http\Model\Article;
use App\Http\Model\Category;
use App\Http\Model\Navs;
use Illuminate\Http\Request;

use App\Http\Requests;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\View;

class CommonController extends Controller
{
    //查询公共导航栏
    public function __construct(){
        $topcate=(new Category)->topcate();
        //查询最新博文
        $Artnew=(new Article)->getartnew();
        //计算所有博文总数
        $Artcount=(new Article)->artcount();
        //将参数共享到所有页面
        View::share('topcate',$topcate);
        View::share('Artnew',$Artnew);
        View::share('Artcount',$Artcount);


    }

}
