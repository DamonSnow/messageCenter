@extends('index.index')

@section('content')
    <div  class="col w10" >
        <a href="{{url('group_insert')}}" style=" margin: 10px 30px ;font-size:18px" class="pull-right">Add Group</a>
        <div class="content" >
            @include('index.message')
            <table >
                <thead>
                <tr>
                    <th width="120">No.</th>
                    <th width="120">Group Name</th>
                    <th width="120">Group Info</th>
                    <th width="120">Creator</th>
                    <th width="120">Create Time</th>
                    <th width="200">Operate</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1;?>
                @foreach($groups as $group)
                    <tr>
                        <td>{{$i}}</td>
                        <td>{{$group->main_group_name}}</td>
                        <td>{{$group->main_group_info}}</td>
                        <td>{{$group->creator}}</td>
                        <td>{{$group->created_time}}</td>
                        <td>
                            <a href="{{url('group_update',['id'=>$group->id])}}">Modify</a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="{{ url('group_delete',['id'=>$group->id]) }} "onclick=" if(confirm('确定删除吗？') == false) return false">Delete</a>
                        </td>
                    </tr>
                    <?php $i++?>
                @endforeach
                </tbody>
            </table>
        </div>
        <div>
            <div class="pull-right">
                {{ $groups->render() }}
            </div>
        </div>

    </div>

@stop