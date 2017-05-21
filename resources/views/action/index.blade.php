@extends('index.index')

@section('javascript')
    <script>
//        $(document).ready(function () {
//
//        });
        function delete_action() {

//            layer.confirm('确认你的操作?', {icon: 3, title:'提示'}, function( )
//            {
//                //确认后处理的事情，这里写入你要进行的操作：数据处理等；
//                layer.close( );//关闭弹窗
//            });
        }



    </script>

@stop


@section('content')
    <div   class="col w10" >
        <a href="{{url('action_insert')}}" style=" margin: 10px 30px ;font-size:18px" class="pull-right">Add Action</a>
        <div class="content" >
            @include('index.message')
            <table >
                <thead>
                <tr>
                    <th width="60">No.</th>
                    <th width="120">Action For Short</th>
                    <th width="120">Action Name </th>
                    <th width="120">From Client</th>
                    <th width="120">Category</th>
                    <th width="150">Info</th>
                    <th width="200">Operate</th>
                </tr>
                </thead>
                <tbody>
                <?php $i = 1; ?>
                @foreach($actions as $action)
                    <tr >
                        <td>{{$i}}</td>
                        <td>{{$action->action}}</td>
                        <td>{{$action->action_name}}</td>
                        <td>{{$action->from_client}}</td>
                        <td>{{$action->category}}</td>
                        <td>{{$action->info}}</td>
                        <td>
                            <a href="{{url('action_update',['id'=>$action->id] )}}">Modify</a>
                            &nbsp;&nbsp;&nbsp;
                            <a href="{{url('action_delete',['id'=>$action->id])}}"  id="delete" onclick="if(confirm('确定删除吗？') == false) return false;">Delete</a>
                        </td>
                    </tr>
                    <?php $i++ ?>
                @endforeach
                </tbody>
            </table>
        </div>
        <div>
            <div class="pull-right">
                {{ $actions->render() }}
            </div>
        </div>

    </div>
@stop