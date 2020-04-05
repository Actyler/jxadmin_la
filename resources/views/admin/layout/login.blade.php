<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title>H+ 后台主题UI框架</title>
    <meta name="keywords" content="">
    <meta name="description" content="">

    <!--[if lt IE 9]>
    <meta http-equiv="refresh" content="0;ie.html" />
    <![endif]-->

    <link rel="shortcut icon" href="favicon.ico">
    <link href="{{ asset('static/admin/css/bootstrap.min.css?v=3.3.6') }}" rel="stylesheet">
    <link href="{{ asset('static/admin/css/font-awesome.min.css?v=4.4.0') }}" rel="stylesheet">
    <link href="{{ asset('static/admin/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('static/admin/css/style.css?v=4.1.0') }}" rel="stylesheet">

    <script>if(window.top !== window.self){ window.top.location = window.location;}</script>
</head>

<body class="gray-bg">

    <div class="middle-box text-center loginscreen  animated fadeInDown">
        <div>
            <div>
                <h1 class="logo-name">H+</h1>
            </div>
            <h3>欢迎使用 H+</h3>

            <form class="m-t" role="form" action="login" method="post">
                <div class="form-group">
                    <input type="text" class="form-control" placeholder="用户名" required="" name="nickname">
                </div>
                <div class="form-group">
                    <input type="password" class="form-control" placeholder="密码" required="" name="password">
                </div>
                <button type="submit" class="btn btn-primary block full-width m-b">登 录</button>

                <p class="text-muted text-center">
                    <a href="login.html#"><small>忘记密码了？</small></a>
                </p>
            </form>
        </div>
    </div>

    <!-- 全局js -->
    <script src="{{ asset('static/admin/js/jquery.min.js?v=2.1.4') }}"></script>
    <script src="{{ asset('static/admin/js/bootstrap.min.js?v=3.3.6') }}"></script>

</body>
</html>
