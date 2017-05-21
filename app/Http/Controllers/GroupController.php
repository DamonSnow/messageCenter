<?php
/**
 * Created by PhpStorm.
 * User: admin
 * Date: 2017/5/2
 * Time: 8:50
 */

namespace App\Http\Controllers;


use App\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class GroupController extends Controller{
    public function index(){
        $group = Group::paginate(13);
        return view('group.index',[
            'groups'=>$group
        ]);
    }

    public function insert(Request $request){
        if($request->isMethod('POST')){
            $group_name = $_POST['group_name'];
            $group_info = $_POST['group_info'];
            $num = $_POST['num'];
            DB::beginTransaction();
            try{
                $main_id =  DB::table('main_group')->insertGetId([
                    'main_group_name' => $group_name,
                    'main_group_info' => $group_info,
                    'critical_num' => $num,
                    'creator' => session('user')['name'],
                    'creator_id' => session('user')['id'],
                    'created_time'=> date('Y-m-d H:i:s',time()),
                    'updated_time'=> date('Y-m-d H:i:s',time())
                ]);
                for($i=0;$i<$num;$i++){
                    $class_id = DB::table('class_group')->insertGetId([
                       'class_group_name' => ''.$group_name.'_'.($i+1).'',
                       'main_group_id' =>$main_id,
                       'main_group_name' =>$group_name,
                       'info' =>$group_info,
                        'creator' => session('user')['name'],
                        'creator_id' => session('user')['id'],
                       'created_time'=>date('Y-m-d H:i:s',time()),
                       'updated_time'=>date('Y-m-d H:i:s',time())
                    ]);
                    if(isset($_POST['actions']) && $_POST['actions']!=''){
                        foreach ($_POST['actions'] as $action) {
                            $temp = explode(',',$action);
                            DB::table('action_group')->insert([
                                'action_id' => $temp[0],
                                'action' => $temp[1],
                                'class_group_id' => $class_id,
                                'class_group_name' => ''.$group_name.'_'.($i+1).'',
                                'main_group_id' =>$main_id,
                                'main_group_name' =>$group_name,
                                'critical_level' => ($i+1),
                                'upgrade_time' =>($i+1)*60,
                                'creator' => session('user')['name'],
                                'creator_id' => session('user')['id'],
                                'created_time'=>date('Y-m-d H:i:s',time()),
                                'updated_time'=>date('Y-m-d H:i:s',time())
                            ]);
                        }
                    }
                }
                DB::commit();
                echo  redirect('group_index')->with('success','添加成功！');
            }catch (\Exception $e){
                DB::rollBack();
                echo  redirect('group_index')->with('error','添加失败！');
            }
        }
        $select_id = DB::select("select id,action,category,info from action where id NOT in (select action_id from action_group )");
        return view('group.insert',[
            'action_ids' => $select_id
        ]);
    }



    public function update($serial,Request $request){
        if($request->isMethod('POST')){
            //POST请求,修改数据
//
//            $data = $request->input('Group');
//            $this->validate($request, [
//                'Group.name' => 'required',
//                'Group.info' => 'required',
//            ], [
//                'required' => ':attribute is Required',
//            ], [
//                'Group.name' => 'Group Name',
//                'Group.info' => 'Group Info',
//            ]);
//            try{
//                DB::table('group')->where('id',$serial)->update([
//                    'name' => $data['name'],
//                    'info' => $data['info']
//                ]);
//                return redirect('group_index')->with('success','修改成功！');
//            }catch (\Exception $e){
//                return redirect('group_index')->with('error','修改失败！');
//            }
        }
        $group = Group::where('id', '=', '' . $serial . '')->get()->first();
        $select_id = DB::select("SELECT id,action,category,info FROM action WHERE id NOT IN ( SELECT action_id FROM action_group) OR id IN (SELECT
			                    action_id FROM action_group  where main_group_id = $serial)");
        $action_groups = DB::select("SELECT distinct action,action_id,main_group_id,main_group_name 
                                    FROM action_group WHERE main_group_id = $serial ");
        return view('group.update',[
            'group' => $group,
            'action_ids' => $select_id,
            'action_group' =>$action_groups
        ]);
    }

    public function group_update_info(Request $request){
        if($request->isMethod('POST')){
            $group_name =  $_POST['group_name'];
            $group_id =  $_POST['group_id'];
            $group_info =  $_POST['group_info'];
            DB::beginTransaction();
            try{
                DB::table('main_group')->where('id',$group_id)->update([
                    'main_group_name' => $group_name,
                    'main_group_info' => $group_info,
                    'updated_time' =>date('Y-m-d H:i:s',time())
                ]);
                if((empty($_POST['actions'])) and (!isset($_POST['actions']))){
                    //传递过来的内容为空，则直接删除所有映射关系
                    DB::delete(" delete from action_group where main_group_id = '$group_id'");
                }else{
                    $action_group_new = $_POST['actions'];
                    //1.得到post值之后，开始更新action_group表
                    $action_group_tbl = array();
                    $action_tbl = DB::select("SELECT action_id,action,main_group_id,main_group_name FROM action_group WHERE main_group_id = '$group_id'  GROUP BY action");
                    if(isset($action_tbl)){
                        foreach ($action_tbl as $at){
                            $temp = (array)$at;
                            array_push($action_group_tbl,$temp["action_id"]);
                        }
                    }
                    var_dump($action_group_tbl);
                    var_dump($action_group_new);
                    $action_group_new_id = array();
                    $action_group_new_name = array();
                    foreach ($action_group_new as $agn){
                        $temp = explode(',',$agn);
                        array_push($action_group_new_id,$temp[0]);
                        array_push($action_group_new_name,$temp[1]);
                    }
                    //数据库中已存在的集合设为A
                    //页面传递过来的集合设为B
                    //如果集合A不在集合B中，就删除
                    $delete_access_ids = array_diff($action_group_tbl,$action_group_new_id);
                    if(isset($delete_access_ids) && count($delete_access_ids)>0){
                        foreach($delete_access_ids as $dai ){
                            DB::delete(" delete from action_group where action_id = '$dai' and main_group_id = $group_id ");
                        }
                    }

                    //如果集合B不在集合A中，就添加
                    $insert_access_ids = array_diff($action_group_new_id,$action_group_tbl);
                    $class_group_info = DB::select("SELECT id,class_group_name from  class_group where main_group_id = $group_id ");

                    foreach ($action_group_new as $agn) {
                        $temp = explode(',',$agn);
                        foreach ($insert_access_ids as $iac){
                            if($temp[0] == $iac){
                                foreach ($class_group_info as $cgi){
                                    DB::table('action_group')->insert([
                                        'action_id' => $temp[0],
                                        'action' => $temp[1],
                                        'class_group_id' => $cgi->id,
                                        'class_group_name' => $cgi->class_group_name,
                                        'main_group_id' =>$group_id,
                                        'main_group_name' =>$group_name,
                                        'critical_level' => substr($cgi->class_group_name,-1),
                                        'upgrade_time' =>substr($cgi->class_group_name,-1)*60,
                                        'creator' => session('user')['name'],
                                        'creator_id' => session('user')['id'],
                                        'created_time'=>date('Y-m-d H:i:s',time()),
                                        'updated_time'=>date('Y-m-d H:i:s',time())
                                    ]);
                                }
                            }
                        }
                    }

                }
                DB::commit();
                echo  redirect('group_index')->with('success','修改成功！');
            }catch (\Exception $e){
                DB::rollBack();
                echo  redirect('group_index')->with('error','修改失败！'.$e.'');
            }
        }
    }


    public function delete($serial){
        DB::beginTransaction();
        try{
            DB::table('main_group')->where('id',$serial)->delete();
            DB::table('class_group')->where('main_group_id',$serial)->delete();
            DB::table('action_group')->where('main_group_id',$serial)->delete();
            DB::table('group_user')->where('main_group_id',$serial)->delete();
            DB::commit();
            return redirect('group_index')->with('success','删除成功！');
        }catch (\Exception $e){
            DB::rollBack();
            return redirect('group_index')->with('error','删除失败！');
        }
    }


}