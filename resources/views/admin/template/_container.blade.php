<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="renderer" content="webkit"/><!-- 让360浏览器默认选择webkit内核 -->

    <!-- 全局css -->
    <link rel="shortcut icon" href="{{ asset('static/favicon.ico') }}">
    <link href="{{ asset('static/admin/css/bootstrap.min.css?v=3.3.6') }}" rel="stylesheet">
    <link href="{{ asset('static/admin/css/font-awesome.css?v=4.4.0') }}" rel="stylesheet">
    <link href="{{ asset('static/admin/css/plugins/bootstrap-table/bootstrap-table.min.css') }}" rel="stylesheet">
    <link href="{{ asset('static/admin/css/plugins/validate/bootstrapValidator.min.css') }}" rel="stylesheet">
    <link href="{{ asset('static/admin/css/animate.css') }}" rel="stylesheet">
    <link href="{{ asset('static/admin/css/style.css?v=4.1.0') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('static/admin/js/plugins/layui/css/layui.css?ver=170803') }}"  media="all">
    @yield("style")
    <link href="{{ asset('static/admin/css/plugins/iCheck/custom.css') }}" rel="stylesheet">
    <link href="{{ asset('static/admin/css/plugins/webuploader/webuploader.css') }}" rel="stylesheet">
    <link href="{{ asset('static/admin/css/plugins/ztree/zTreeStyle.css') }}" rel="stylesheet">
    <link href="{{ asset('static/admin/css/plugins/jquery-treegrid/css/jquery.treegrid.css') }}" rel="stylesheet"/>
    <!-- <link href="{{-- asset('static/admin/css/plugins/ztree/demo.css') --}}" rel="stylesheet"> -->

    <!-- 全局js -->
    <script src="{{ asset('static/admin/js/jquery.min.js?v=2.1.4') }}"></script>
    <script src="{{ asset('static/admin/js/bootstrap.min.js?v=3.3.6') }}"></script>
    <script src="{{ asset('static/admin/js/plugins/ztree/jquery.ztree.all.min.js') }}"></script>
    <script src="{{ asset('static/admin/js/plugins/bootstrap-table/bootstrap-table.min.js') }}"></script>
    <script src="{{ asset('static/admin/js/plugins/validate/bootstrapValidator.min.js') }}"></script>
    <script src="{{ asset('static/admin/js/plugins/validate/zh_CN.js') }}"></script>
    <script src="{{ asset('static/admin/js/plugins/bootstrap-table/bootstrap-table-mobile.min.js') }}"></script>
    <script src="{{ asset('static/admin/js/plugins/bootstrap-table/locale/bootstrap-table-zh-CN.min.js') }}"></script>
    <script src="{{ asset('static/admin/js/plugins/jquery-treegrid/js/jquery.treegrid.min.js') }}"></script>
    <script src="{{ asset('static/admin/js/plugins/jquery-treegrid/js/jquery.treegrid.bootstrap3.js') }}"></script>
    <script src="{{ asset('static/admin/js/plugins/jquery-treegrid/extension/jquery.treegrid.extension.js') }}"></script>
    <script src="{{ asset('static/admin/js/plugins/layer/layer.min.js') }}"></script>
    <script src="{{ asset('static/admin/js/plugins/iCheck/icheck.min.js') }}"></script>
    <script src="{{ asset('static/admin/js/plugins/layer/laydate/laydate.js') }}"></script>
    <script src="{{ asset('static/admin/js/plugins/webuploader/webuploader.min.js') }}"></script>
    <script src="{{ asset('static/admin/js/common/ajax-object.js') }}"></script>
    <script src="{{ asset('static/admin/js/common/bootstrap-table-object.js') }}"></script>
    <script src="{{ asset('static/admin/js/common/tree-table-object.js') }}"></script>
    <script src="{{ asset('static/admin/js/common/web-upload-object.js') }}"></script>
    <script src="{{ asset('static/admin/js/common/ztree-object.js') }}"></script>
    <script src="{{ asset('static/admin/js/common/Feng.js') }}"></script>
    <script type="text/javascript" src="{{ asset('static/admin/js/ueditor/ueditor.config.js') }}"></script>
    <script type="text/javascript" src="{{ asset('static/admin/js/ueditor/ueditor.all.min.js') }}"> </script>
    <script type="text/javascript" src="{{ asset('static/admin/js/xheditor/xheditor-1.2.2.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('static/admin/js/xheditor/xheditor_lang/zh-cn.js') }}"></script>

</head>

<body class="gray-bg">
<div class="wrapper wrapper-content animated fadeInRight">
    @yield("content")
</div>
<script src="{{ asset('static/admin/js/content.js?v=1.0.0') }}"></script>
@yield("script")
</body>
</html>
