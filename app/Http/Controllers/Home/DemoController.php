<?php
namespace App\Http\Controllers\Home;
use App\Http\Model\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class DemoController extends Controller
{
    public function add(){
       $userlist= (new User)->Userlist();
        dd($userlist);
    }

}
