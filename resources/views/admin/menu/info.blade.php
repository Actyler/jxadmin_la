@extends("admin.template._container")
@section("content")
<div class="ibox float-e-margins">
    <input type="hidden" name='action' id='action' value="{{ $action }}" />
    <input type="hidden" name='menu_id' id='menu_id' value="{{ $info->menu_id ?? '' }}" />
    <div class="ibox-content layui-form">
        <div class="form-horizontal" id="CodeInfoForm">
            <div class="row" style="margin-top:-20px;">
                <div class="layui-tab layui-tab-brief" lay-filter="test">
                    <ul class="layui-tab-title">
                        <li class="layui-this">基本信息</li>
                        <li>拓展信息</li>
                    </ul>
                    <div class="layui-tab-content" style="margin-top:10px;">
                        <div class="layui-tab-item layui-show">
                            <div class="col-sm-12">
                                <!-- form start -->

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">所属父类：</label>
                                    <div class="col-sm-9">
                                        <select lay-ignore name="pid" class="form-control" id="pid">
                                            <option value="" data-level="0">请选择父类</option>
                                            @foreach($menu_list as $vo)
                                                @isset($info->menu_id)@continue($vo->menu_id == $info->menu_id)@endisset
                                                <option value="{{ $vo->menu_id }}" data-level="{{ $vo->level }}">{{ $vo->ctitle }}</option>
                                            @endforeach
                                        </select>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">菜单名称：</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="title" value="{{ $info->title ?? '' }}" name="title" class="form-control" placeholder="请输入菜单名称">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">控制器名：</label>
                                    <div class="col-sm-9">
                                        <input type="text" value="{{ $info->controller ?? '' }}" id="controller" name="controller" class="form-control" placeholder="请输入控制器名">
                                        <span class="help-block m-b-none">支持二级控制器，例如 Sys/Goods  </span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">数据库表名：</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="table_name" value="{{ $info->table ?? '' }}" name="table" class="form-control" placeholder="请输入数据库表名">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">主键：</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="pk_id" value="{{ $info->pk ?? '' }}" name="pk" class="form-control" placeholder="请输入主键名称">
                                    </div>
                                </div>

                                <div class="form-group">
                                    <label class="col-sm-2 control-label">是否生成代码：</label>
                                    <div class="col-sm-9">
                                        <input name="is_create" value="1" type="radio"  title="是">
                                        <input name="is_create" value="0" type="radio"  title="否">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">是否生成数据表：</label>
                                    <div class="col-sm-9">
                                        <input name="is_table" value="1" type="radio" title="是">
                                        <input name="is_table" value="0" type="radio" title="否">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">是否菜单：</label>
                                    <div class="col-sm-9">
                                        <input name="status" value="1" type="radio" title="是">
                                        <input name="status" value="0" type="radio" title="否">
                                    </div>
                                </div>


                                <!-- form end -->
                            </div>
                        </div>

                        <div class="layui-tab-item">
                            <div class="col-sm-12">
                                <!-- form start -->
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">url地址：</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="url" name="url" value="{{ $info->url ?? '' }}" class="form-control" placeholder="请输入url地址">
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">选项卡配置：</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="tab_menu" name="tab_menu" value="{{ $info->tab_menu ?? '' }}" class="form-control" placeholder="选项卡竖线|隔开">
                                        <span class="help-block m-b-none">例如 基本信息|拓展信息</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">icon图标：</label>
                                    <div class="col-sm-9">
                                        <input type="text" id="icon" name="icon" value="{{ $info->menu_icon ?? '' }}" class="form-control" placeholder="请输入图标">
                                        <span class="help-block m-b-none"><a  target="_blank" style="color:#ff0000" onclick="CodeInfoDlg.icon('menu_icon')">点击查看图标列表 </a></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="col-sm-2 control-label">是否允许投稿：</label>
                                    <div class="col-sm-9">
                                        <input name="is_submit" value="1" type="radio" title="是">
                                        <input name="is_submit" value="0" type="radio" title="否">
                                    </div>
                                </div>
                                <!-- form end -->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="hr-line-dashed"></div>
            <div class="row btn-group-m-t">
                <div class="col-sm-9 col-sm-offset-1">
                    <button type="button" class="btn btn-primary" onclick="CodeInfoDlg.submit();" id="ensure">
                    <i class="fa fa-check"></i>&nbsp;确认提交
                    </button>
                    <button type="button" class="btn btn-danger" onclick="CodeInfoDlg.close()" id="cancel">
                        <i class="fa fa-eraser"></i>&nbsp;取消
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
<script src="{{ asset('static/admin/js/admin/Menu.js?t=3453') }}') }}" charset="utf-8"></script>
<script src="{{ asset('static/admin/js/plugins/layui/layui.js?t=1498856285724') }}" charset="utf-8"></script>
<script>
    layui.use(['form'], function () {
        window.form = layui.form;
    });
    layui.use('element', function(){
        var element = layui.element;
        element.on('tab(test)', function(elem){});
    });
    $(function () {
        /* 组件初始化状态 --start */

        $("[name='pid']").find("[value='{{ $info->pid ?? '' }}']").attr("selected",true);

        $("[name='is_create'][value='{{ $info->is_create ?? '1' }}']").attr("checked",true);
        $("[name='is_table'][value='{{ $info->is_table ?? '1' }}']").attr("checked",true);
        $("[name='is_submit'][value='{{ $info->is_submit ?? '1' }}']").attr("checked",true);
        $("[name='status'][value='{{ $info->status ?? '1' }}']").attr("checked",true);

        /* 组件初始化状态 --end */


    })
</script>

@endsection
