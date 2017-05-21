@extends('index.index')
@section('content')
    {{--href="{{url('user_insert')}}"--}}
    {{--<a  href="#" style=" margin: 10px 30px ;font-size:18px" class="pull-right">Synchronize</a>--}}
    <div class="col w10" >
        <div class="content" >
            @include('index.message')
            <table >
                <thead>
                <tr>
                    <th width="120">No.</th>
                    <th width="120">User Name</th>
                    <th width="120">Email </th>
                    <th width="120">WeChat</th>
                    <th width="120">Department</th>
                    <th width="120">Group</th>
                    <th width="200">Operate</th>
                </tr>
                </thead>
                <tbody>
                @foreach($users as $user)
                <tr >
                    <td>{{$user->id}}</td>
                    <td>{{$user->name}}</td>
                    <td>{{$user->email}}</td>
                    <td>{{$user->wx_id}}</td>
                    <td>{{$user->depart_short}}</td>
                    <td>
                        @foreach($groups as $group)
                            @if($group->user_id == $user->id)
                                {{$group->main_group_name}}<br>
                            @endif
                        @endforeach
                    </td>
                    <td>
                        <a href="{{url('user_update',['id'=>$user->id])}}">Modify</a>
{{--                        <a href="{{ url('user_delete',['id'=>$user->id]) }} "onclick=" if(confirm('确定删除吗？') == false) return false">Disable</a>--}}
                    </td>
                </tr>
                @endforeach
                </tbody>
            </table>
        </div>
        <div>
            <div class="pull-right">
                {{ $users->render() }}
            </div>
        </div>

    </div>

@stop