<?php
namespace App\Http\Middleware;
use Closure;
use Illuminate\Support\Facades\DB;

class haslogin{
    public function handle($request,Closure $next){
        if(!session('user')){
            return redirect('login');
        }else {
            if(((mb_eregi('^group_',$request->path())) || (mb_eregi('^action_',$request->path())) ) && (session('user')['name'] != 'Admin') ){
//                $allData = $request->all();
//                var_dump($allData);
//                DB::table('operate')->insert([
//                    'user' =>
//                    'user_ip' =>
//                    'post_value' =>
//                    'request_page' => $request->path,
//                    'request_time' => date('Y-m-d H:i:s',time()),
//                    'request_res' => 'false';
//                ]);
                return redirect('user_index')->with('error','不合法的操作！Illegal Operation！');
            }
            else{

//                $allData = $request->all();
//                var_dump($data);
//                dd($allData);
//                dd($request);
                return $next($request);
            }
        }
    }
}