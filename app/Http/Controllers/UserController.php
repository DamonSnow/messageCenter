<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * since: 2017/4/29 18:14
 */

namespace App\Http\Controllers;
use App\Group;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use Illuminate\Support\Facades\Redirect;
use League\Flysystem\Exception;

class UserController extends Controller{
    public function index(){
        if(session('user')['name'] == 'Admin' && session('user')['id'] == 'sysadmin'){
           $user = User::paginate(13);
           $groups = DB::select("SELECT a.user_id,a.main_group_name FROM group_user a LEFT JOIN class_group b ON a.class_group_id = b.id");
        }else{
            $user = DB::table('user')->where('id',session('user')['id'])->paginate(5);
            $groups = DB::select("SELECT a.user_id,a.main_group_name FROM group_user a LEFT JOIN class_group b ON a.class_group_id = b.id");
        }
        return view('user.index',[
            'users' => $user,
            'groups'=>$groups
        ]);
    }
    public function update(Request $request,$serial){
        if($request->isMethod('POST')){
            DB::beginTransaction();
            try{
                $data = $request->input('User');
                $wx_id = $data['wechat'];
                //更新User表，主要是更新微信账号
                DB::table('user')->where('id',''.$serial.'')->update([
                    'wx_id' => $wx_id
                ]);
                DB::commit();
                return redirect()->action('UserController@user_group',['id'=>$serial]);
            }catch (\Exception $e){
                DB::rollBack();
                return   redirect('user_index')->with('error',''.$e.'');
            }
        }
        $user = User::where('id', '=', '' . $serial . '')->get()->first();
        if(!$user){
            return  redirect('user_index')->with('error','User is not exist！');
        }else if(($serial != session('user')['id']) AND (session('user')['name'] != 'Admin')){
            return redirect('user_index')->with('error','不合法的操作！Illegal Operation！');
        }else{
            return view('user.update',[
                'user' => $user
            ]);
        }
    }


//    public function update_user_group(Request $request){
//        if($request->isMethod('POST')) {
//            DB::beginTransaction();
//            try{
//                $user_name = $_POST['user_name'];
//                $user_id = $_POST['id'];
//                $wx_id = $_POST['wechat'];
//                $group_new = json_decode($_POST['access_ids']);
//                //更新User表，主要是更新微信账号
//                DB::table('user')->where('id',''.$user_id.'')->update([
//                    'wx_id' => $wx_id
//                ]);
////                DB::update(" update user set wx_id = '$wx_id' where id = '$user_id' ");
//                //更新group_user表
//                //1.得到这个user原先所在group的group_id
//                $group_ids_tbl = array();
//                $group_tbl = DB::select("select group_id from group_user where user_id = '$user_id'   ");
//                if(isset($group_tbl)){
//                    foreach ($group_tbl as $gt){
//                        $temp = (array)$gt;
//                        array_push($group_ids_tbl,$temp["group_id"]);
//                    }
//                }
//                $delete_access_ids = array_diff($group_ids_tbl,$group_new);
//                if(isset($delete_access_ids) && count($delete_access_ids)>0){
//                    foreach($delete_access_ids as $dai ){
//                        DB::delete(" delete from group_user where user_id = '$user_id' and group_id = $dai ");
//                    }
//                }
//                $insert_access_ids = array_diff($group_new,$group_ids_tbl);
//                if(isset($insert_access_ids) && count($insert_access_ids)>0){
//                    foreach($insert_access_ids as $iai){
//                        DB::table('group_user')->insert([
//                            'user_id' =>$user_id,
//                            'user_name'=>$user_name,
//                            'group_id'=>$iai,
//                            'modifier_id'=>'1',
//                            'modifier'=>'Admin',
//                            'modify_time'=>date('Y-m-d H:i:s')
//                        ]);
//                    }
//                }
//                DB::commit();
//                echo  redirect('user_index')->with('success','修改成功！');
//            }catch(\Exception $e){
//                DB::rollBack();
//                echo  redirect('user_index')->with('error','修改失败！');
//            }
//
//        }
//    }
    public function user_group($id){
        if(($id != session('user')['id']) AND (session('user')['id'] != 'sysadmin') ){
            return redirect('user_index')->with('error','不合法的操作！Illegal Operation！');
        }else{
            $actions = DB::select("SELECT main_group_name,action FROM action_group GROUP BY action");
            $main_groups= DB::select("select main_group_name from main_group ");
            $class_groups = DB::select("SELECT id,class_group_name,main_group_id,main_group_name from class_group");
            $user_groups = DB::select("select user_id,class_group_id,class_group_name from group_user where user_id = '$id'");
            return view('user.group_user',[
                'user_id' => $id,
                'actions' => $actions,
                'main_groups' => $main_groups,
                'class_groups' => $class_groups,
                'user_groups' => $user_groups
            ]);
        }
    }

    public function user_add_group(Request $request){
        if($request->isMethod('POST')){
            DB::beginTransaction();
            try{
                if($_POST['user_id'] != session('user')['id'] AND (session('user')['id'] != 'sysadmin')){
                    throw new Exception("不合法的操作！Illegal Operation！");
                }else{
                    $user_id = $_POST['user_id'];
                    if(empty($_POST['group_ids']) or (!isset($_POST['group_ids']))){
                        //传递过来的内容为空，则直接删除所有映射关系
                        DB::delete(" delete from group_user where user_id = '$user_id'");
                    }else{
                        $group_ids_new = $_POST['group_ids'];
                        //得到post值之后，开始更新group_user表
//                1.得到这个user原先所在group的group_id
                        $group_ids_tbl = array();
                        $group_tbl = DB::select(" select class_group_id from group_user where user_id = '$user_id' ");
                        if(isset($group_tbl)){
                            foreach ($group_tbl as $gt){
                                $temp = (array)$gt;
                                array_push($group_ids_tbl,$temp["class_group_id"]);
                            }
                        }
                        //数据库中已存在的集合设为A
                        //页面传递过来的集合设为B
                        //如果集合A不在集合B中，就删除
                        $delete_access_ids = array_diff($group_ids_tbl,$group_ids_new);
                        if(isset($delete_access_ids) && count($delete_access_ids)>0){
                            foreach($delete_access_ids as $dai ){
                                DB::delete(" delete from group_user where user_id = '$user_id' and class_group_id = $dai ");
                            }
                        }
                        //如果集合B不在集合A中，就添加
                        $insert_access_ids = array_diff($group_ids_new,$group_ids_tbl);
                        $creator_id = session('user')['id'];
                        $creator = session('user')['name'];
                        if(isset($insert_access_ids) && count($insert_access_ids)>0){
                            foreach($insert_access_ids as $iai){
                                $group_info = DB::select("SELECT id,class_group_name,main_group_id,main_group_name FROM class_group WHERE id = $iai ");
                                foreach ($group_info as $gi){
                                    DB::insert("INSERT INTO group_user (user_id,user_name,class_group_name,class_group_id,main_group_name,main_group_id ,creator_id,creator,created_time,updated_time) SELECT
	                                        '$user_id',NAME,'$gi->class_group_name','$gi->id','$gi->main_group_name','$gi->main_group_id','$creator_id','$creator',NOW(),NOW() FROM `user` WHERE id = '$user_id'");

                                }
                            }
                        }
                    }
                    DB::commit();
                    echo  redirect('user_index')->with('success','设置成功！');
                }
            }catch(\Exception $e){
                DB::rollBack();
                echo  redirect('user_index')->with('error','设置失败！'.$e.'');
            }
        }
    }



}