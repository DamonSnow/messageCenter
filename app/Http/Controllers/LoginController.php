<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * since: 2017/4/29 13:36
 */
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\User;
use App\Http\Requests;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class LoginController extends Controller {

    public function login(Request $request){
        if($request->isMethod('POST') && $request->input()){
            $data = $request->input();
            echo $data['username'];
            echo $data['password'];
            $user = User::where('id',$data['username'])->get()->first();
            if(empty($user) || $user->password != $data['password'])
            {
                return back()->with('msg','用户或密码错误');
            }
            session(['user'=>$user]);
            return Redirect::to('user_index');
//            return view('index/index');
        }else{
            return view('index/login');
        }
    }


    public function logout()
    {
        session(['user'=>null]);
        return redirect('login');
    }
}