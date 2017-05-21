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
                {{--var group_id = [];--}}
                {{--var col = 0;--}}
                {{--var max_col = $("#table").find("thead").find("tr").find("td").length;--}}
                {{--var temp_str = '' ;--}}
                {{--try{--}}
                    {{--$(":checkbox:checked").parents("tr").find("input.text").each(function () {--}}
                        {{--if ($(this).val() != '') {--}}
                            {{--if(col == 0){--}}
                                {{--group_id.push($(this).val());--}}
                            {{--}--}}
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
                    {{--return false;--}}
                {{--}--}}

                {{--var id = $("#id").val();--}}
                {{--var action = $("#action").val();--}}
                {{--var action_name = $("#name").val();--}}
                {{--var client = $("#client").val();--}}
                {{--var category = $("#category").val();--}}
                {{--var info = $("#info").val();--}}
                {{--if(!( action  && action_name && client && category && info)){--}}
                    {{--layer.alert('Action信息填写不完整！', {--}}
                        {{--icon: 8, skin: 'layer-ext-moon',--}}
                    {{--});--}}
                    {{--return false;--}}
                {{--}--}}
                {{--$.ajax({--}}
                    {{--type:'POST',--}}
                    {{--url :'{{url('action_update_info')}}',--}}
                    {{--dataType: 'text',--}}
                    {{--data: { action_group: temp_str,--}}
                        {{--"_token": "{{csrf_token()}}",--}}
                        {{--action_id:id,--}}
                        {{--group_id:group_id,--}}
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
{{--//                        alert(XMLHttpRequest.readyState);--}}
{{--//                        alert(textStatus);--}}
{{--//                        alert(errorThrown);--}}
{{--//                        window.location.reload();--}}
                    {{--}--}}
                {{--})--}}
            {{--});--}}
        {{--})--}}
    {{--</script>--}}
{{--@stop--}}
@section('content')
    <div class="panel panel-default">
        <div class="panel-heading">Modify Action</div>
        <div class="panel-body">
            {{--加载警告信息--}}
            @include('index.message')
            @include('action.form')
        </div>
    </div>
@stop