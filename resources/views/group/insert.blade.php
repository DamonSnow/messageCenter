@extends('index.index')


@section('javascript')
    <script>
    $(document).ready(function () {
        $("#button").click(function () {
            var group_name = $("#name").val();
            var group_info = $("#info").val();
            var num = $("#num").val();
            var actions = [];
            $('input[name="action_group"]:checked').each(function(){
                actions.push($(this).val());
            });

//            alert(actions);

            $.ajax({
                type:'POST',
                url :'{{url('group_insert')}}',
                dataType: 'html',
                data: { group_name: group_name,
                    "_token": "{{csrf_token()}}",
                    group_info:group_info,
                    num:num,
                    actions : actions
                },
                success: function (data) {
                },
                error: function (XMLHttpRequest, textStatus, errorThrown) {
                },
                complete : function (XMLHttpRequest, textStatus) {

//                    if (XMLHttpRequest.status == "200") {
//                        layer.confirm('新增成功！', {
//                            btn: ['确定'],
//                            icon: 1
//                        }, function(){
//                            window.location="./group_index";
//                        });
//                    }else{
//                        layer.confirm('新增失败！', {
//                            btn: ['确定'],
//                            icon: 8
//                        }, function(){
//                            window.location="./group_index";
//                        });
//                    }
                    window.location="./group_index";
                }
            })
        })
    })
    </script>

@stop


@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Add Group</div>
        <div class="panel-body">
            {{--加载警告信息--}}
            @include('index.message')
            <form class="form-horizontal" method="post" action="" id="form">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">Group Name:</label>
                    <div class="col-sm-5">
                        <input placeholder="" type="text" name="Group[name]" value="{{old('Group')['name']}}" class="form-control" id="name" >
                    </div>
                    <div class="col-sm-3">
                        <p class="form-control-static text-danger">{{$errors->first('Group.name')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="info" class="col-sm-3 control-label">Group Info:</label>
                    <div class="col-sm-5">
                        <textarea  placeholder="" name="Group[info]" value="{{old('Group')['info']}}" class="form-control" id="info" ></textarea>
                    </div>
                    <div class="col-sm-3">
                        <p class="form-control-static text-danger">{{$errors->first('Group.info')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="num" class="col-sm-3 control-label">Group Critical Num:</label>
                    <div class="col-sm-4">
                        <input placeholder="设置需要多少个发送等级" type="number" min="1" max="5" name="Group[num]" value="{{old('Group')['num']}}" class="form-control" id="num" >
                    </div>
                    {{--<div><label class="col-sm-1">默认为3</label></div>--}}
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
                                    <td><input type="checkbox" name="action_group"  style="margin:0 10px;" value="{{$action->id}},{{$action->action}}"></td>
                                    <td><label style="font-weight:normal">{{$action->action}}</label></td>
                                    <td><label style="font-weight:normal">{{$action->info}}</label></td>
                                    <td><label style="font-weight:normal">{{$action->category}}</label></td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                     </div>
                    {{--<div class="col-sm-5">--}}
                        {{--<input placeholder="设置需要多少个发送等级" type="number" min="0" name="Group[num]" value="{{old('Group')['num']}}" class="form-control" id="num" >--}}
                    {{--</div>--}}
                    <div class="col-sm-3">
                        <p class="form-control-static text-danger">{{$errors->first('Group.num')}}</p>
                    </div>
                </div>
                <div class="form-group">

                    <div class="col-sm-offset-4 col-sm-1">
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