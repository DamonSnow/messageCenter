<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
    <meta name="keywords" content="" />
    <meta name="description" content="" />
    <title>Alarm Center Login</title>

    <script src="{{asset('resources/js/jquery.js')}}" type="text/javascript" charset="utf-8"></script>
{{--    <script src="{{asset('resources/js/menu.js')}}" type="text/javascript" charset="utf-8"></script>--}}
    <script src="{{asset('resources/js/global.js')}}" type="text/javascript" charset="utf-8"></script>
    <script src="{{asset('resources/js/modal.js')}}" type="text/javascript" charset="utf-8"></script>
    <link rel="stylesheet" href="{{asset('resources/css/style.css')}}" type="text/css" media="screen" charset="utf-8" />
</head>
<body>
<div id="wrapper_login">
    <div id="menu">
        <div id="left"></div>
        <div id="right"></div>
        <h2>Message Center Login</h2>
        <div class="clear"></div>
    </div>
    <div id="desc">
        <div class="body">
            <div class="col w10 last bottomlast">
                <form action="#" method="post">
                    {{csrf_field()}}
                    @if(session('msg'))
                        <p style="color:red">{{session('msg')}}</p>
                    @endif
                    <p>
                        <label for="username">Username:</label>
                        <input type="text" name="username" id="username" value="" size="40" class="text" />
                        <br />
                    </p>
                    <p>
                        <label for="password">Password:</label>
                        <input type="password" name="password" id="password" value="" size="40" class="text" />
                        <br />
                    </p>
                    <p class="last">
                        <input type="submit" value="Login" class="novisible" />
                        <a href="" class="button form_submit"><small class="icon play"></small><span>Login</span></a>
                        <br />
                    </p>
                    <div class="clear"></div>
                </form>
            </div>
            <div class="clear"></div>
        </div>
        <div class="clear"></div>
        <div id="body_footer">
            <div id="bottom_left"><div id="bottom_right"></div></div>
        </div>
    </div>
</div>
</body>
</html>