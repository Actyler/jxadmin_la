<!DOCTYPE html>
<html lang="zh-cn">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit">

    <title>H+ 后台主题UI框架</title>

    <link rel="shortcut icon" href="{{ asset('/static/favicon.ico')}}">
    <link href="{{ asset('/static/admin/css/bootstrap.min.css?v=3.3.6') }}" rel="stylesheet">
    <link href="{{ asset('/static/admin/css/font-awesome.min.css?v=4.4.0') }}" rel="stylesheet">
    <link href="{{ asset('/static/admin/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('/static/admin/css/style.css?v=4.1.0') }}" rel="stylesheet">
</head>

<body class="fixed-sidebar full-height-layout gray-bg" style="overflow:hidden">
    <div id="wrapper">

        <!--左侧导航开始-->
        @include('admin.layout.left')
        <!--左侧导航结束-->

        <!--右侧部分开始-->
        @include('admin.layout.right')
        <!--右侧部分结束-->

        <!--右侧边栏开始-->
        @include('admin.layout.slidebar')
        <!--右侧边栏结束-->

        <!--mini聊天窗口开始-->
        @include('admin.layout.chat')
        <!--mini聊天窗口结束-->

    </div>

    <!-- 全局js -->
    <script src="{{ asset('/static/admin/js/jquery.min.js?v=2.1.4') }}"></script>
    <script src="{{ asset('/static/admin/js/bootstrap.min.js?v=3.3.6') }}"></script>
    <script src="{{ asset('/static/admin/js/plugins/metisMenu/jquery.metisMenu.js') }}"></script>
    <script src="{{ asset('/static/admin/js/plugins/slimscroll/jquery.slimscroll.min.js') }}"></script>
    <script src="{{ asset('/static/admin/js/plugins/layer/layer.min.js') }}"></script>

    <!-- 自定义js -->
    <script src="{{ asset('/static/admin/js/hplus.js?v=4.1.0') }}"></script>
    <script type="text/javascript" src="{{ asset('/static/admin/js/contabs.js') }}"></script>

    <!-- 第三方插件 -->
    <script src="{{ asset('/static/admin/js/plugins/pace/pace.min.js') }}"></script>
    <script>
        $(function(){
            $("#cache").click(function(){
                Feng.confirm("是否删除缓存？", function () {
                    $.ajax({
                        url: '{:url("admin/Base/clearData")}',
                        success:function(data){
                            if(data.status == '00'){
                                layer.msg(data.msg, {
                                    icon: 1,
                                    time: 1000
                                });
                            }else{
                                layer.msg(data.msg, {
                                    icon: 2,
                                    time: 1000
                                });
                            }
                        }
                    })
                });
            })
        })
    </script>

</body>

</html>
