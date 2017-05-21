<?php
/**
 * Created by PhpStorm.
 * User: Admin
 * since: 2017/4/29 20:38
 */
namespace App\Http\Controllers;
use App\Action;
use App\Action_Group;
use App\Http\Requests;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\QueryException;
use League\Flysystem\Exception;

class ActionController extends Controller{
    public function index(){
        $action = Action::paginate(13);
        return view('action.index',[
            'actions'=>$action
        ]);
    }

    public function insert(Request $request){
        if($request->isMethod('POST') ) {
            $data = $request->input('Action');
            $this->validate($request, [
                'Action.action' => 'required',
                'Action.name' => 'required',
                'Action.client' => 'required',
                'Action.category' => 'required',
                'Action.info' => 'required',
            ], [
                'required' => ':attribute is Required',
            ], [
                'Action.action' => 'Action For Short',
                'Action.name' => 'Action Name',
                'Action.client' => 'Client',
                'Action.category' => 'Category',
                'Action.info' => 'Info'
            ]);
            DB::beginTransaction();
            try{
                if($data['action']){
                    $action = $data['action'];
                    $result = Action::where('action',''.$action.'')->get();
                    if(!$result->isEmpty()){
                        return  redirect('action_index')->with('error','添加失败!该Action已经存在!');
                    }else{
                        if($data['client'] == 1){
                            $from_client = 'MES';
                        }elseif ($data['client'] == 2){
                            $from_client = 'EDC';
                        }else{
                            $from_client = 'ERP';
                        }
                        DB::table('action')->insert([
                            'action'=>$action,
                            'action_name'=>$data['name'],
                            'from_client_id'=>$data['client'],
                            'from_client'=>$from_client,
                            'category'=>$data['category'],
                            'info'=> $data['info'],
                            'creator' => session('user')['name'],
                            'creator_id' => session('user')['id'],
                            'created_time'=>date('Y-m-d H:i:s',time()),
                            'updated_time'=>date('Y-m-d H:i:s',time())
                        ]);
                        DB::commit();
                        return  redirect('action_index')->with('success','添加成功！');
                    }
                }
            }catch (\Exception $e){
                DB::rollBack();
                return  redirect('action_index')->with('error','添加失败');
            }
        }
        return view('action.insert');
    }

    public function update(Request $request,$serial){
        if($request->isMethod('POST')){
            $data = $request->input('Action');
            $this->validate($request, [
                'Action.name' => 'required',
                'Action.client' => 'required',
                'Action.category' => 'required',
                'Action.info' => 'required',
            ], [
                'required' => ':attribute is Required',
            ], [
                'Action.name' => 'Action Name',
                'Action.client' => 'Client',
                'Action.category' => 'Category',
                'Action.info' => 'Info'
            ]);
            DB::beginTransaction();
            try{
                if($data['client'] == 1){
                    $from_client = 'MES';
                }elseif ($data['client'] == 2){
                    $from_client = 'EDC';
                }else{
                    $from_client = 'ERP';
                }
                DB::table('action')->where('id',''.$serial.'')->update([
                    'action_name' => $data['name'],
                    'from_client_id' => $data['client'],
                    'from_client' =>$from_client,
                    'category' => $data['category'],
                    'info' => $data['info'],
                    'updated_time'=>date('Y-m-d H:i:s',time())
                ]);
                DB::commit();
                return  redirect('action_index')->with('success','修改成功！');
            }catch(\Exception $e){
                DB::rollBack();
                return  redirect('action_index')->with('error','修改失败！');
            }

        }
        $action = Action::where('id', '=', '' . $serial . '')->get()->first();
        return view('action.update',[
            'action'=>$action
        ]);
    }


    public function delete($serial){
        DB::beginTransaction();
        try{
            DB::table('action')->where('id',$serial)->delete();
            DB::table('action_group')->where('action_id',$serial)->delete();
            DB::commit();
            return  redirect('action_index')->with('success','删除成功！');
        }catch (\Exception $e){
            DB::rollBack();
            return  redirect('action_index')->with('error','删除失败！');
        }
    }

    //修改页面传递过来更新完毕的数据，在这里进行更新
//    public function update_info(Request $request){
//        if($request->isMethod('POST')) {
//            DB::beginTransaction();
//            try{
//                $action = $_POST['action'];
//                if($_POST['client'] == 1){
//                    $from_client = 'MES';
//                }elseif ($_POST['client'] == 2){
//                    $from_client = 'EDC';
//                }else{
//                    $from_client = 'ERP';
//                }
//                //更新action表
//                DB::table('action')->where('id', $_POST['action_id'])->update([
//                    'action'=>$action,
//                    'action_name'=>$_POST['action_name'],
//                    'from_client_id'=>$_POST['client'],
//                    'from_client'=>$from_client,
//                    'category'=>$_POST['category'],
//                    'info'=> $_POST['info']
//                ]);
//
//                //更新action_group表
//                //已有的group集合是A，界面传递过来的group集合是B
//                //数据库中搜寻集合A
//                $action_group_tbl = DB::select("SELECT group_id,critical_level,upgrade_time FROM action_group WHERE action = '$action' ");
//                //页面传递过来的集合B
//                $action_group_temp = $_POST['action_group'];
//                if ($action_group_temp != '') {
//                    $group_ids = $_POST['group_id'];
//                    //1.先将post过来的数据组合成一个二维数组
//                    $groups = explode(';', $action_group_temp);
//                    for ($i = 0; $i < count($groups) - 1; $i++) {
//                        $temp = explode(',', $groups[$i]);
//                        for($j=0;$j<count($temp);$j++){
//                            $action_group_new[$i][$j] = $temp[$j];
//                        }
//                    }
//                    //2.如果存在集合A 且A中的某个group不在B中，执行删除，
//                    $group_ids_tbl = array();
//                    if(isset($action_group_tbl)){
//                        foreach($action_group_tbl as $gat ){
//                            $gat_temp = (array)$gat;//$gat为object stdClass
//                            array_push($group_ids_tbl,$gat_temp["group_id"]);
//                            if(!in_array($gat_temp["group_id"],$group_ids)){
//                                $groupid = $gat_temp["group_id"];
//                                DB::delete("delete from action_group where group_id = '$groupid' and action = '$action'");
//                            }
//                        }
//                    }
//    //
//    //                    //3.存在集合B，B中的某个group不在A中，执行添加
//                    if($action_group_new) {
//                        foreach ($action_group_new as $agn) {
//                            if (!in_array($agn[0], $group_ids_tbl)) {
//                                DB::table('action_group')->insert([
//                                    'action'=>$action,
//                                    'group_id'=>$agn[0],
//                                    'critical_level'=>$agn[1],
//                                    'upgrade_time'=>$agn[2],
//                                    'creator_id'=> '1',
//                                    'creator'=>'Admin',
//                                    'create_time'=>date("Y-m-d H:i:s")
//                                ]);
//                            } else {
//                                foreach ($action_group_tbl as $agt) {
//                                    $gat_temp = (array)$agt;
//                                    if (!judgeEqual($agn, $gat_temp)) {
//    //                                        //完全相等，break;
//                                        break;
//                                    } else {
//                                        //更新 critical or upgrade_time
//                                        if($agn[0] == $gat_temp['group_id']){
//                                            DB::update("update action_group set critical_level = '$agn[1]',upgrade_time = '$agn[2]' WHERE action = '$action' and group_id = '$agn[0]' ");
//                                            var_dump($agn);                                            break;
//                                        }
//                                    }
//                                }
//                            }
//                        }
//                    }
//                }else{
//    //                    页面传递过来的是一个空字符串，直接删除已有集合
//                    DB::delete("delete from action_group where action = '$action'");
//                }
//                DB::commit();
//                echo  redirect('action_index')->with('success','修改成功！');
//            }catch(\Exception $e){
//                DB::rollBack();
//                echo  redirect('action_index')->with('error','修改失败！');
//            }
//        }
//    }

}
function judgeEqual($key1,$key2){
    if(array_diff($key1,$key2) || array_diff($key2,$key1)){
        return true;
    }else{
        return false;
    }
}