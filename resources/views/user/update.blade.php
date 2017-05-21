@extends('index.index')

{{--@section('css')--}}
    {{--<style type="text/css">--}}
        {{--input[type=checkbox]{--}}
            {{--margin:10px 10px;--}}
        {{--}--}}
    {{--</style>　--}}
{{--@stop--}}
{{--@section('javascript')--}}
    {{--<script>--}}
        {{--$(document).ready(function () {--}}
            {{--$("#button").click(function () {--}}
                {{--var access_ids = [];--}}
                {{--$("input[type='checkbox']").each(function () {--}}
                    {{--if($(this).prop("checked")){--}}
                        {{--access_ids.push($(this).val());--}}
                    {{--}--}}
                {{--})--}}
                {{--var user_name = $("#user_name").val();--}}
                {{--var wechat = $("#wechat").val();--}}
                {{--var id = $("#user_id").val();--}}
                {{--$.ajax({--}}
                    {{--type:'POST',--}}
                    {{--url :'{{ url('user_update_group') }}',--}}
                    {{--dataType: 'text',--}}
                    {{--data: {--}}
                        {{--user_name:user_name,--}}
                        {{--access_ids : JSON.stringify(access_ids),--}}
                        {{--"_token": "{{csrf_token()}}",--}}
                        {{--wechat : wechat,--}}
                        {{--id: id--}}
                    {{--},--}}
                    {{--success: function (data) {--}}
                        {{--window.location.reload();--}}
                    {{--},--}}
                    {{--error: function (XMLHttpRequest, textStatus, errorThrown) {--}}
{{--//                        alert('添加失败！');--}}
{{--//                        alert(XMLHttpRequest.status);--}}
{{--//                        alert(XMLHttpRequest.readyState);--}}
                        {{--alert(textStatus);--}}
{{--//                        alert(errorThrown);--}}
{{--//                        window.location.reload();--}}
                    {{--}--}}
                {{--})--}}
            {{--})--}}
        {{--})--}}
    {{--</script>--}}
{{--@stop--}}

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">User Info Modify</div>
        <div class="panel-body">
            @include('index.message')
            <form id="user_form" class="form-horizontal" method="post" action="">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="id" class="col-sm-3 control-label">No：</label>
                    <div class="col-sm-6">
                        <input type="hidden" value="{{$user->serial}}" name="User[serial]">
                        <input  readonly="true" id="user_id"  type="text" name="User[id]" value="{{$user->id }}" class="form-control" id="id" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">Name:</label>
                    <div class="col-sm-6">
                        <input readonly="true" id="user_name" type="text" name="User[name]" value="{{$user->name }}" class="form-control" id="name" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="email" class="col-sm-3 control-label">Email：</label>
                    <div class="col-sm-6">
                        <input readonly="true" type="text" name="User[email]" value="{{$user->email }}" class="form-control" id="email" >
                    </div>
                </div>
                <div class="form-group">
                    <label for="wechat" class="col-sm-3 control-label">Wechat：</label>
                    <div class="col-sm-6">
                        <input type="text" name="User[wechat]" value="{{$user->wx_id }}" id="wechat" class="form-control" id="wechat" >

                    </div>
                    <div class="col-sm-2">
                        <p class="form-control-static text-danger">{{$errors->first('User.wechat')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="dept" class="col-sm-3 control-label">Department：</label>
                    <div class="col-sm-6">
                        <input  readonly="true" type="text" name="User[dept]" value="{{$user->depart_short }}" class="form-control" id="dept" >
                    </div>
                </div>
                {{--<div class="form-group">--}}
                    {{--<label for="dept" class="col-sm-3 control-label">Group：</label>--}}
                    {{--<div class="col-sm-6">--}}
                        {{--@foreach($group_user as $gu)--}}
                            {{--<input type="checkbox" name="access_group[]"  value="{{$gu->id}}" {{isset($gu->user_id)&&isset($gu->user_name)?'checked':'' }}>{{$gu->name}}({{$gu->info}})<br>--}}
                        {{--@endforeach--}}
                    {{--</div>--}}
                {{--</div>--}}
                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-1">
                        <input  type="button" style="width: 100px;" class="btn btn-info"  onclick="javascript:history.back(-1);" value="Return">
                    </div>
                    <div class="col-sm-offset-1 col-sm-1">
                        <input id="button" style="width:160px;" type="submit" class="btn btn-info" value="Submit and Next">
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop