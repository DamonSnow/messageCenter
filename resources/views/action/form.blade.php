<form class="form-horizontal" method="post" action="{{url('action_update',['id'=>$action->id])}}">
    {{csrf_field()}}
    <div class="form-group">
        <label for="action" class="col-sm-3 control-label">Action For Short:</label>
        <div class="col-sm-5">
            <input type="hidden" name="Action[id]" value="{{$action->id}}" id="id">
            <input type="text" readonly="readonly" name="Action[action]" value="{{old('Action')['action']?old('Action')['action']:$action->action }}" class="form-control" id="action" >
        </div>
        <div class="col-sm-3">
            <p class="form-control-static text-danger">{{$errors->first('Action.action')}}</p>
        </div>
    </div>
    <div class="form-group">
        <label for="name" class="col-sm-3 control-label">Action Name:</label>
        <div class="col-sm-5">
            <input type="text" name="Action[name]" value="{{old('Action')['name']?old('Action')['name']:$action->action_name }}" class="form-control" id="name" >
        </div>
        <div class="col-sm-3">
            <p class="form-control-static text-danger">{{$errors->first('Action.name')}}</p>
        </div>
    </div>

    <div class="form-group">
        <label for="client" class="col-sm-3 control-label">From Client:</label>
        <div class="col-sm-5">
            <select name="Action[client]" id="client">
                <option value="1" {{$action->from_client_id == '1'?'selected':''}}>MES</option>
                <option value="2" {{$action->from_client_id == '2'?'selected':''}}>EDC</option>
                <option value="3" {{$action->from_client_id == '3'?'selected':''}}>ERP</option>
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
                <option {{$action->category == 'Machine Alarm'?'selected':''}}>Machine Alarm</option>
                <option {{$action->category == 'Hold Lot'?'selected':''}}>Hold Lot</option>
                <option {{$action->category == 'Photoresist'?'selected':''}}>Photoresist</option>
                <option {{$action->category == 'OOS/OOC'?'selected':''}}>OOS/OOC</option>
            </select>
        </div>
        <div class="col-sm-3">
            <p class="form-control-static text-danger">{{$errors->first('Action.category')}}</p>
        </div>
    </div>
    <div class="form-group">
        <label for="info" class="col-sm-3 control-label">Info:</label>
        <div class="col-sm-5">
            <textarea name="Action[info]"  class="form-control" id="info" >{{old('Action')['info']?old('Action')['info']:$action->info}}</textarea><br>
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
                {{--@foreach($action_groups as $ag)--}}
                    {{--<tr>--}}
                        {{--<td ><input name="target" type="checkbox" style="margin:0 10px;" value="{{$ag->id}}" {{isset($ag->critical_level)&&isset($ag->upgrade_time)?'checked':'' }}>{{$ag->name}}</td>--}}
                        {{--<td><input  name="Action[group_id]" type="hidden" value="{{$ag->id}}" class="text">--}}
                            {{--<input name="Action[level]" type="number" class="text" min="1" value="{{$ag->critical_level}}" > </td>--}}
                        {{--<td><input  name="Action[up_time]" type="number" class="text" min="0" value="{{$ag->upgrade_time}}"></td>--}}
                        {{--<td><label>({{$ag->info}})</label></td>--}}
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