<!DOCTYPE html>
<html lang="zh">
    <head>
        <meta charset="utf-8">
        <title>管理员登陆 - 后台管理</title>
        <meta name="renderer" content="webkit">
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <meta name="viewport" content="width=device-width, initial-scale=1.0, minimum-scale=1.0, maximum-scale=1.0, user-scalable=0">
        <!-- CSS -->
        <link rel="stylesheet" href="{{ asset('static/admin/js/plugins/layui/css/layui.css?ver=170803') }}"  media="all">
        <link rel="stylesheet" href="{{ asset('static/admin/css/admin.css') }}" media="all">
        <link rel="stylesheet" href="{{ asset('static/admin/css/login.css') }}" media="all">
        <script src="{{ asset('static/admin/js/jquery.min.js?v=2.1.4') }}"></script>
        <script src="{{ asset('static/admin/js/plugins/layer/layer.min.js') }}"></script>
        <script src="{{ asset('static/admin/js/common/ajax-object.js') }}"></script>
        <script src="{{ asset('static/admin/js/common/Feng.js') }}"></script>
        <style type="text/css">
            body{
                background-image: url("{{ asset('static/admin/img/denglu.jpg') }}");
            }
            .layadmin-user-login-main{
                z-index:1;
                background-color:  #FFF;
                border-radius: 1em;
                border:1px solid #fff;

            }
            #jx_check{
                text-align: center;
                margin-bottom: 20px;
                max-width: 100%;
            }
            #embed-captcha {
                max-width: 100%;
                margin: 0 auto;
            }
            .show {
                display: block;
            }
            .hide {
                display: none;
            }
            .layui-input:focus,.layui-textarea:focus{border-color:#1E9FFF!important}
            #notice {
                color: red;
            }
        </style>
    </head>
    <body>

    <div class="layadmin-user-login layadmin-user-display-show" id="LAY-user-login" style="display: none;">

        <div class="layadmin-user-login-main">
            <div class="layadmin-user-login-box layadmin-user-login-header">
                <h2>{{ config('xhadmin.site_title') }}</h2>
            </div>
            <div class="layadmin-user-login-box layadmin-user-login-body layui-form">
                <div class="layui-form-item">
                    <label class="layadmin-user-login-icon layui-icon layui-icon-username" for="LAY-user-login-username"></label>
                    <input type="text" name="nickname" id="nickname" lay-verify="required" placeholder="用户名" class="layui-input">
                </div>
                <div class="layui-form-item">
                    <label class="layadmin-user-login-icon layui-icon layui-icon-password" for="LAY-user-login-password"></label>
                    <input type="password" name="password" id="password" lay-verify="required" placeholder="密码" class="layui-input">
                </div>
                @if (config('captcha.enable'))
                <div class="layui-form-item">
                    <div class="layui-row">
                        <div class="layui-col-xs7">
                            <label class="layadmin-user-login-icon layui-icon layui-icon-vercode" for="LAY-user-login-vercode"></label>
                            <input type="text" name="verity" id="verify" placeholder="验证码" class="layui-input">
                        </div>
                        <div class="layui-col-xs5">
                            <div style="margin-left: 10px;">
                                <img id="img" class="verifyImg layadmin-user-login-codeimg" id="LAY-user-get-vercode" onclick="this.src=this.src" src="{{ captcha_src() }}" />
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <div class="layui-form-item">
                    <button class="layui-btn layui-btn-fluid layui-bg-blue" onclick="login()" id="login">登陆</button>
                </div>


            </div>
        </div>

        <div class="layui-trans layadmin-user-login-footer">
            <p>© 2020 <a href="http://www.xhadmin.com" target="_blank">Copyright © 2018-2020 xhadmin All Rights Reserved.</a></p>
        </div>
    </div>


    </body>
</html>

<script type="text/javascript">
    document.onkeydown = function(e){
        var ev = document.all ? window.event : e;
        if(ev.keyCode==13) {
            login();
        }
    };

    function login(){
        var nickname = $("#nickname").val();
        var password = $("#password").val();


        if(!nickname || !password){
            Feng.info("请输入用户名或者密码！");
            return false;
        }

        if( "{{ config('captcha.enable') }}"){
            var verify = $("#verify").val();
            if(!verify){
                Feng.info("请输入验证码！");
                return false;
            }
        }


        var ajax = new $ax("login", function (data) {
            if (1 === data.status) {
                Feng.success(data.msg);
                $("#submit").val('正在登陆');
                window.location.href= data.url;
            } else {
                if( "{{ config('captcha.enable') }}") {
                    $("#img").attr('src', "{{ captcha_src() }}");
                }
                Feng.error(data.msg);
            }

        });
        ajax.set('nickname',nickname);
        ajax.set('password',password);
        if( "{{ config('captcha.enable') }}") {
            ajax.set('verify', verify);
        }
        ajax.start();
    }

</script>
