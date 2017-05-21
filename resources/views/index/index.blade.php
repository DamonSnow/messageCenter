<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN"
        "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <link rel="shortcut icon" href="{{asset('public/favicon.ico')}}">
    <link rel="Bookmark" href="{{asset('public/favicon.ico')}}">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <title>Alarm Center</title>



    <link rel="stylesheet" href="{{asset('resources/css/style.css')}}" type="text/css" media="screen" charset="utf-8" />
    <link href="{{asset('resources/css/bootstrap.min.css?v=3.3.6')}}" rel="stylesheet">
    <link href="{{asset('resources/css/font-awesome.min.css?v=4.4.0')}}" rel="stylesheet">
    <link href="{{asset('resources/css/animate.css')}}" rel="stylesheet">
    <link href="{{asset('resources/css/style.css?v=4.1.0')}}" rel="stylesheet">
    @section('css')

    @show

    <script src="{{asset('resources/js/jquery.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('resources/js/jquery.min.js?v=2.1.4')}}"></script>
    <script src="{{asset('resources/js/bootstrap.min.js?v=3.3.6')}}"></script>
{{--    <script src="{{asset('resources/js/global.js')}}" type="text/javascript" charset="utf-8"></script>--}}
    <script src="{{asset('resources/js/modal.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('resources/js/plugins/metisMenu/jquery.metisMenu.js')}}"></script>
    <script src="{{asset('resources/js/plugins/slimscroll/jquery.slimscroll.min.js')}}"></script>
    <script src="{{asset('resources/js/plugins/layer/layer.min.js')}}"></script>
    @section('javascript')
    @show
</head>
<body>
<div id="header">
    <div class="col w5 bottomlast">
        <a href="" class="logo">
            <img src="{{asset('resources/images/logo.gif')}}" alt="Logo" />

        </a>
    </div>
    <div class="col w5 last right bottomlast">
        <p class="last" style="margin: 0 25px 0 0">Logged in as <span class="strong" style="font-size: 14px;">{{session('user')['name']}},</span>&nbsp;&nbsp;<a href="{{url('logout')}}">Logout</a></p>
    </div>
    <div class="clear"></div>
</div>

<div id="wrapper"  >
    <div id="minwidth">
        <div id="holder">
            <div id="menu">
                <div id="left"></div>
                <div id="right"></div>
                <ul>
                    @if(session('user')['name'] == 'Admin' && session('user')['id'] == 'sysadmin')
                        <li>
                            <a href="{{url('action_index')}}" class="{{preg_match_all('/^\/action_/',Request::getPathInfo())?'selected':''}}"><span style="font-size:18px;">Setting Actions</span></a>
                        </li>
                        <li>
                            <a href="{{url('group_index')}}"  class="{{preg_match_all('/^\/group_/',Request::getPathInfo())?'selected':''}}"><span style="font-size:18px;">Setting Groups</span></a>
                        </li>
                    @endif
                    <li>
                        <a href="{{url('user_index')}}"  class="{{preg_match_all('/^\/user_/',Request::getPathInfo())?'selected':''}}"><span style="font-size:18px;">Setting Users</span></a>
                    </li>
                </ul>
                <div class="clear"></div>
            </div>

            <div id="desc">
                <div class="body">
                    <div class="clear"></div>
                    @section('content')

                    @show
                    <div class="clear"></div>
                </div>
                <div class="clear"></div>
                <div id="body_footer">
                    <div id="bottom_left"><div id="bottom_right"></div></div>
                </div>
            </div>
        </div>
    </div>
</div>
<div id="footer">
    <p >Copyright 2017 - Alarm Center - Created by <a target="_blank" href="http://www.unicompound.com/" >Unicompound</a></p>
</div>
</body>
</html>