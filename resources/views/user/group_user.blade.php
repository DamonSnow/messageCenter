@extends('index.index')



@section('css')
    <style type="text/css">
        form #table{
            width: 900px;
            margin: auto;
            /*border: 2px;*/
            /*cellspacing:"0";*/
            /*cellpadding:"0";*/
        }
    </style>　


@stop



@section('javascript')
    <script>
        $(document).ready(function () {

            $(".action").each(function(){
                if($.trim($(this).html()) == ""){
                    var group_name = $.trim($(this).parent("tr").find("td").eq(0).text());
                    $(this).next("td").find("input").each(function () {
//                        if(!$(this).attr('checked')){
                            $(this).attr('disabled','disabled');
//                        }
                    })
                }
            });



            $("#button").click(function () {
                var class_group_ids = []
                $("#table :checked").each(function () {
//                    alert($(this).val());
                    class_group_ids.push($(this).val());
                });

                var user_id = $("#user_id").val();


                $.ajax({
                    type:'POST',
                    url :'{{url('user_add_group')}}',
                    dataType: 'html',
                    data: { group_ids: class_group_ids,
                        "_token": "{{csrf_token()}}",
                        user_id:user_id
                    },
                    success: function (data, textStatus) {

                    },
                    error: function (XMLHttpRequest, textStatus, errorThrown) {

                    },
                    complete: function (XMLHttpRequest, textStatus) {

//                        if (XMLHttpRequest.status == "200") {
//                            layer.confirm('设置成功！', {
//                                btn: ['确定'],
//                                icon: 1
//                            }, function(){
//                                window.location="../user_index";
//                            });
//                        }else{
//                            layer.confirm('设置失败！', {
//                                btn: ['确定'],
//                                icon: 8
//                            }, function(){
//                                window.location="../user_index";
//                            });
//                        }
                        window.location="../user_index";
                    }
                })
            })

            $("input[type=radio]").bind('click',function(){

                if($(this).attr('checked')){
                    $(this).removeAttr('checked');
                }else{
                    $(this).attr('checked','checked');
                }
            });


        })
    </script>
@stop




@section('content')
    <div><br><br></div>
    <form id="user_form" class="form-horizontal" method="post" action="" class="form-control">
        {{csrf_field()}}
        <input type="hidden" value="{{$user_id}}" id="user_id">
        <table class="table"  id="table">
            <thead>
                <td style="font-weight:bold">Group</td>
                <td style="font-weight:bold">Action</td>
                <td style="font-weight:bold">Critical Level(low->high)</td>
            </thead>
            <tbody>
                @foreach($main_groups as $mg)
                    <tr>
                        <td>
                            {{$mg->main_group_name}}
                        </td>
                        <td class="action">
                            @foreach($actions as $action)
                                @if($action->main_group_name == $mg->main_group_name)
                                    {{$action->action}}<br>
                                @endif
                            @endforeach
                        </td>
                        <td>
                            @foreach($class_groups as $cg)
                                @if($cg->main_group_name == $mg->main_group_name)
                                    <input type="radio" class="target"  name="{{$mg->main_group_name}}" value="{{$cg->id}}"
                                    @foreach($user_groups as $ug)
                                        @if($ug->class_group_id == $cg->id)
                                            checked
                                        @endif
                                    @endforeach
                                    >{{$cg->class_group_name}}
                                @endif
                            @endforeach
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div><br><br><br></div>
        <div class="form-group">
            <div class="col-sm-offset-3 col-sm-1">
                <input  type="button" style="width: 100px;" class="btn btn-info"  onclick="javascript:history.back(-1);" value="Return">
            </div>
            <div class="col-sm-offset-1 col-sm-1">
                <input id="button" style="width: 100px;" type="button" class="btn btn-info" value="Submit">
            </div>
        </div>
    </form>
@stop
