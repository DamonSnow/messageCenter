@extends('index.index')


@section('javascript')
    <script>
        $(document).ready(function () {
            $('#button').click(function () {
                var group_id = $("#id").val();
                var group_name = $("#name").val();
                var group_info = $("#info").val();
                var actions = [];
                $('input[name="action_group"]:checked').each(function(){
                    actions.push($(this).val());
                });

                $.ajax({
                    type:'POST',
                    url :'{{url('group_update_info')}}',
                    dataType: 'text',
                    data: { group_name: group_name,
                        "_token": "{{csrf_token()}}",
                        group_id:group_id,
                        group_info:group_info,
                        actions : actions
                    },
                    success: function (data) {
                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {
                    },
                    complete : function (XMLHttpRequest, textStatus) {

//                        if (XMLHttpRequest.status == "200") {
//                            layer.confirm('修改成功！', {
//                                btn: ['确定'],
//                                icon: 1
//                            }, function(){
//                                window.location="../group_index";
//                            });
//                        }else{
//                            layer.confirm('修改失败！', {
//                                btn: ['确定'],
//                                icon: 8
//                            }, function(){
//                                window.location="../group_index";
//                            });
//                        }
                        window.location="../group_index";
                    }
                })
            });
        });
    </script>
@stop
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Modify Group</div>
        <div class="panel-body">
            {{--加载警告信息--}}
            @include('index.message')
            <form class="form-horizontal" method="post" action="">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">Group Name:</label>
                    <div class="col-sm-5">
                        <input type="hidden" name="Group[id]" id="id"  value="{{$group->id}}">
                        <input type="text" name="Group[name]" value="{{$group->main_group_name}}" class="form-control" id="name" >
                    </div>
                    <div class="col-sm-3">
                        <p class="form-control-static text-danger">{{$errors->first('Group.name')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="info" class="col-sm-3 control-label">Group Info:</label>
                    <div class="col-sm-5">
                        <textarea name="Group[info]"  class="form-control" id="info" >{{$group->main_group_info}}</textarea>
                    </div>
                    <div class="col-sm-3">
                        <p class="form-control-static text-danger">{{$errors->first('Group.info')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="num" class="col-sm-3 control-label">Group Critical Num:</label>
                    <div class="col-sm-4">
                        <input readonly="readonly" type="number" min="0" name="Group[num]" value="{{$group->critical_num}}" class="form-control" id="num" >
                    </div>
                    <div class="col-sm-3">
                        <p class="form-control-static text-danger">{{$errors->first('Group.num')}}</p>
                    </div>
                </div>


                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">Set Action:</label>
                    <div class="col-sm-5">
                        <table class="table" style="width:600px" id="table">
                            <thead>
                            <td></td>
                            <td style="font-weight:bold">Action</td>
                            <td style="font-weight:bold">Action Describe</td>
                            <td style="font-weight:bold">Category</td>
                            </thead>
                            <tbody>
                            @foreach($action_ids as $action)
                                <tr>
                                    <td><input type="checkbox" name="action_group"  style="margin:0 10px;" value="{{$action->id}},{{$action->action}}"
                                        @foreach($action_group as $ag)
                                            @if($ag->action_id == $action->id)
                                                checked
                                            @endif
                                        @endforeach    ></td>
                                    <td><label style="font-weight:normal">{{$action->action}}</label></td>
                                    <td><label style="font-weight:normal">{{$action->info}}</label></td>
                                    <td><label style="font-weight:normal">{{$action->category}}</label></td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="col-sm-3">
                        <p class="form-control-static text-danger">{{$errors->first('Group.action')}}</p>
                    </div>
                </div>


                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-1">
                        <input  type="button" class="btn btn-info"  onclick="javascript:history.back(-1);" value="Return">
                    </div>
                    <div class="col-sm-offset-1 col-sm-1">
                        <input id="button"  type="button" class="btn btn-info" value="Submit">
                    </div>
                </div>
            </form>
        </div>
    </div>

@stop