@extends('index.index')

@section('javascript')

    <script>
        $(document).ready(function () {

            $(":button").click(function() {

                // 找到选中行的input

                var ipts = $(":checkbox:checked").parents("tr").find("input:text");
                    // 遍历input并使用val()方法获取值
                str = ipts.map(function() {return $(this).val();}).get().join(", ");

                alert(str);

            });

        });
    </script>
@stop



@section('content')


<table>

    <tr>

        <td><input type="checkbox" name="test"></td>

        <td><input type="text"></td><td><input type="text"></td>

    </tr>

    <tr>

        <td><input type="checkbox" name="test"></td>

        <td><input type="text"></td><td><input type="text"></td>

    </tr>

</table>

<input type="button" value="确定">


@stop