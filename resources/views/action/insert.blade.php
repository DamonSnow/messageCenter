@extends('index.index')
@section('css')
    <style type="text/css">
        input.text{
            width:100px;
        }
    </style>　
@stop
{{--@section('javascript')--}}

    {{--<script>--}}
        {{--$(document).ready(function () {--}}
            {{--$("#button").click(function () {--}}
                {{--//得到这个table有几列--}}
                {{--var col = 0;--}}
                {{--var max_col = $("#table").find("thead").find("tr").find("td").length;--}}
                {{--var temp_str = '' ;--}}
                {{--try{--}}
                    {{--$(":checkbox:checked").parents("tr").find("input.text").each(function () {--}}
                        {{--if ($(this).val() != '') {--}}
                            {{--if(col == max_col-1){--}}
                                {{--temp_str += $(this).val();--}}
                                {{--temp_str += ';';--}}
                                {{--col = 0;--}}
                            {{--}else{--}}
                                {{--temp_str += $(this).val();--}}
                                {{--temp_str += ',';--}}
                                {{--col++;--}}
                            {{--}--}}
                        {{--}else{--}}
                            {{--throw 'error';--}}
                        {{--}--}}
                    {{--});--}}
                {{--}catch(err){--}}
                    {{--layer.alert('Groups信息不完整！', {--}}
                        {{--icon: 8, skin: 'layer-ext-moon'--}}
                    {{--});--}}
{{--//                    return false;--}}
                {{--}--}}


                {{--var action = $("#action").val();--}}
                {{--var action_name = $("#name").val();--}}
                {{--var client = $("#client").val();--}}
                {{--var category = $("#category").val();--}}
                {{--var info = $("#info").val();--}}
                {{--if(!( action  && action_name && client && category && info)){--}}
                    {{--layer.alert('Action信息填写不完整！', {--}}
                        {{--icon: 8, skin: 'layer-ext-moon'--}}
                    {{--});--}}
                    {{--return false;--}}
                {{--}--}}
                {{--$.ajax({--}}
                    {{--type:'POST',--}}
                    {{--url :'{{url('action_insert')}}',--}}
                    {{--dataType: 'text',--}}
                    {{--data: { action_group: temp_str,--}}
                        {{--"_token": "{{csrf_token()}}",--}}
                        {{--action : action,--}}
                        {{--action_name:action_name,--}}
                        {{--client:client,--}}
                        {{--category:category,--}}
                        {{--info:info--}}
                    {{--},--}}
                    {{--success: function (data) {--}}
                        {{--window.location.reload();--}}
                    {{--},--}}
                    {{--error: function (XMLHttpRequest, textStatus, errorThrown) {--}}
{{--//                        alert('添加失败！');--}}
                        {{--alert(XMLHttpRequest.status);--}}
                        {{--alert(XMLHttpRequest.readyState);--}}
                        {{--alert(textStatus);--}}
                        {{--alert(errorThrown);--}}
{{--//                        window.location.reload();--}}
                    {{--}--}}
                {{--})--}}
            {{--});--}}
        {{--})--}}
    {{--</script>--}}
{{--@stop--}}

@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Add Action</div>
        <div class="panel-body">
            {{--加载警告信息--}}
            @include('index.message')
            <form class="form-horizontal" method="post" action="">
                {{csrf_field()}}
                <div class="form-group">
                    <label for="action" class="col-sm-3 control-label">Action For Short:</label>
                    <div class="col-sm-5">
                        <input type="text" name="Action[action]" value="{{old('Action')['action']}}" class="form-control" id="action" >
                    </div>
                    <div class="col-sm-3">
                        <p class="form-control-static text-danger">{{$errors->first('Action.action')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="name" class="col-sm-3 control-label">Action Name:</label>
                    <div class="col-sm-5">
                        <input type="text" name="Action[name]" value="{{old('Action')['name']}}" class="form-control" id="name" >
                    </div>
                    <div class="col-sm-3">
                        <p class="form-control-static text-danger">{{$errors->first('Action.name')}}</p>
                    </div>
                </div>

                <div class="form-group">
                    <label for="client" class="col-sm-3 control-label">From Client:</label>
                    <div class="col-sm-5">
                        <select name="Action[client]" id="client">
                            <option ></option>
                            <option value="1">MES</option>
                            <option value="2">EDC</option>
                            <option value="3">ERP</option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <p class="form-control-static text-danger">{{$errors->first('Action.client')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="client" class="col-sm-3 control-label">Category:</label>
                    <div class="col-sm-5">
                        <select name="Action[category]" id="category">
                            <option ></option>
                            <option>Machine Alarm</option>
                            <option>Hold Lot</option>
                            <option>Photoresist </option>
                            <option>OOS/OOC </option>
                        </select>
                    </div>
                    <div class="col-sm-3">
                        <p class="form-control-static text-danger">{{$errors->first('Action.category')}}</p>
                    </div>
                </div>
                <div class="form-group">
                    <label for="info" class="col-sm-3 control-label">Info:</label>
                    <div class="col-sm-5">
                        <textarea name="Action[info]" value="{{old('Action')['info']}}" class="form-control" id="info" ></textarea><br>
                    </div>
                    <div class="col-sm-3">
                        <p class="form-control-static text-danger">{{$errors->first('Action.info')}}</p>
                    </div>
                </div>
                {{--<div class="form-group">--}}
                    {{--<label for="group" class="col-sm-3 control-label">Groups:</label>--}}
                    {{--<div class="col-sm-5">--}}
                        {{--<table class="table" style="width:600px" id="table">--}}
                            {{--<thead>--}}
                                {{--<tr>--}}
                                    {{--<td width="120"></td>--}}
                                    {{--<td width="100">Critical Level</td>--}}
                                    {{--<td width="80">Up Grade Time(min)</td>--}}
                                    {{--<td width="100">Group Info</td>--}}
                                {{--</tr>--}}
                            {{--</thead>--}}
                            {{--<tbody>--}}
                                {{--@foreach($groups as $group)--}}
                                    {{--<tr>--}}
                                        {{--<td ><input name="target" type="checkbox" style="margin:0 10px;" value="{{$group->id}}">{{$group->name}}</td>--}}
                                        {{--<td><input  name="Action[group_id]" type="hidden" value="{{$group->id}}" class="text"><input name=" Action[level]" type="number" class="text" min="1"></td>--}}
                                        {{--<td><input  name="Action[up_time]" type="number" class="text" min="0"></td>--}}
                                        {{--<td><label>({{$group->info}})</label></td>--}}
                                    {{--</tr>--}}
                                {{--@endforeach--}}
                            {{--</tbody>--}}
                        {{--</table>--}}
                    {{--</div>--}}
                {{--</div>--}}

                <div class="form-group">
                    <div class="col-sm-offset-4 col-sm-1">
                        <input  type="button" class="btn btn-info"  onclick="javascript:history.back(-1);" value="Return">
                    </div>
                    <div class="col-sm-offset-1 col-sm-1">
                        <input id="button"  type="submit" class="btn btn-info" value="Submit">
                    </div>
                </div>
            </form>
        </div>
    </div>
@stop