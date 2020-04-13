@extends("admin.template._container")
@section("content")
<div class="row">
    <div class="col-sm-12">
        <div class="ibox float-e-margins">

            <div class="ibox-content">
                <div class="layui-tab layui-tab-brief" lay-filter="test" style="margin-top:-10px;">
                    <ul class="layui-tab-title">
                        <li class="layui-this" onclick="location.href='{{ url('admin/menu/index') }}'">后台管理</li>
                    </ul>
                </div>
                <div class="row row-lg">
                    <div class="col-sm-12">
                        <div class="btn-group-sm" id="CodeGoodsTableToolbar" role="group">
                            <button type="button" class="btn btn-primary button-margin" onclick="CodeGoods.add()">
                                <i class="glyphicon glyphicon-plus" aria-hidden="true"></i> 创建
                            </button>
                            <button type="button" class="btn btn-primary button-margin" onclick="CodeGoods.update()">
                                <i class="glyphicon glyphicon-pencil" aria-hidden="true"></i> 修改
                            </button>
                            <button type="button" class="btn btn-warning button-margin" onclick="CodeGoods.fieldlist()">
                                <i class="glyphicon glyphicon-plus"></i>&nbsp;字段管理
                            </button>
                            <button type="button" class="btn btn-warning button-margin" onclick="CodeGoods.actionlist()">
                                <i class="glyphicon glyphicon-plus"></i>&nbsp;方法管理
                            </button>
                            <button type="button" class="btn btn-success button-margin" onclick="CodeGoods.createCode()">
                                <i class="glyphicon glyphicon-plus"></i>&nbsp;生成代码
                            </button>
                            <button type="button" class="btn btn-danger button-margin" onclick="CodeGoods.delete()">
                                <i class="glyphicon glyphicon-trash" aria-hidden="true"></i> 卸载
                            </button>
                        </div>
                        <table id="CodeGoodsTable" data-mobile-responsive="true"></table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<link href="{{ asset('static/admin/js/plugins/chosen/chosen.min.css') }}" rel='stylesheet'/>
<script src="{{ asset('static/admin/js/plugins/chosen/chosen.jquery.js') }}"></script>
<script>
    $(function(){$('.chosen').chosen({})});

    var CodeGoods = {id: "CodeGoodsTable",seItem: null,table: null,layerIndex: -1};

    CodeGoods.initColumn = function () {
        return [
            {field: 'selectItem', radio: true},
            {title: '编号', field: 'menu_id', visible: true, align: 'left', valign: 'middle'},
            {title: '排序', field: 'menu_id', visible: true, align: 'center', valign: 'middle',formatter: 'CodeGoods.arrowFormatter'},
            {title: '名称', field: 'ctitle', visible: true, align: 'left', valign: 'middle'},
            {title: '名称', field: 'title', visible: false, align: 'left', valign: 'middle'},
            {title: '控制器名', field: 'controller', visible: true, align: 'left', valign: 'middle'},
            {title: '数据库表名', field: 'table', visible: true, align: 'left', valign: 'middle'},
            {title: '是否生成代码', field: 'is_create', visible: true, align: 'center', valign: 'middle',formatter: 'CodeGoods.is_createFormatter'},
            {title: '显示菜单', field: 'status', visible: true, align: 'center', valign: 'middle',formatter: 'CodeGoods.statusFormatter'},
            {title: '创建数据库表', field: 'is_table', visible: true, align: 'center', valign: 'middle',formatter: 'CodeGoods.tableFormatter'},
            {title: '排序号', field: 'sort', visible: true, align: 'left', valign: 'middle',formatter: 'CodeGoods.sortFormatter'},
            {title: '操作', field: 'menu_id', visible: true, align: 'center', valign: 'middle',formatter: 'CodeGoods.buttonFormatter'},
        ];
    };

    $(function() {
        var defaultColunms = CodeGoods.initColumn();
        var table = new BSTable(CodeGoods.id, "index",defaultColunms,200);
        table.setPaginationType("server");
        table.setQueryParams(CodeGoods.formParams());
        CodeGoods.table = table.init();
    });

    CodeGoods.is_createFormatter = function(value,row,index) {
        if(value !== null){
            if(value === 1){
                return '<input class="mui-switch mui-switch-animbg status'+row.menu_id+'" type="checkbox" onclick="CodeGoods.setStatus(\'is_create\','+row.menu_id+',0)" checked>';
            }else{
                return '<input class="mui-switch mui-switch-animbg status'+row.menu_id+'"  type="checkbox" onclick="CodeGoods.setStatus(\'is_create\','+row.menu_id+',1)">';
            }
        }
    };

    CodeGoods.setStatus = function(field,pk,value) {
        var ajax = new $ax("setStatus", function (data) {
            if (data.status !== 1) {
                Feng.error(data.msg);
                $(".status"+pk).prop("checked",!$(".status"+pk).prop("checked"));
            }
        });
        var val = $(".status"+pk).prop("checked") ? 1 : 0;
        ajax.set('field', field);
        ajax.set('menu_id', pk);
        ajax.set('value', value);
        ajax.start();
    };


    CodeGoods.statusFormatter = function(value,row,index) {
        if(value !== null){
            if(value == 1){
                return '<input class="mui-switch mui-switch-animbg status'+row.menu_id+'" type="checkbox" onclick="CodeGoods.setStatus(\'status\','+row.menu_id+',0)" checked>';
            }else{
                return '<input class="mui-switch mui-switch-animbg status'+row.menu_id+'" type="checkbox" onclick="CodeGoods.setStatus(\'status\','+row.menu_id+',1)">';
            }
        }
    }

    CodeGoods.tableFormatter = function(value,row,index) {
        switch(value){
            case 1:
                return '<span class="label label-success ">是</div>';
                break;
            case 0:
                return '<span class="label label-warning ">否</div>';
                break;
        }
    };


    CodeGoods.buttonFormatter = function(value,row,index) {
        if(value){
            var str= '';
            str += '<button type="button" class="btn btn-primary btn-xs" title="修改"  onclick="CodeGoods.update('+value+')"><i class="fa fa-edit"></i> 修改</button>&nbsp;'
            str += '<button type="button" class="btn btn-danger btn-xs" title="卸载"  onclick="CodeGoods.delete('+value+')"><i class="fa fa-trash"></i> 卸载</button>&nbsp;'
            return str;
        }
    };

    CodeGoods.sortFormatter = function(value,row,index) {
        return '<input type="text" value="'+value+'" onblur="CodeGoods.upsort('+row.menu_id+',this.value)" style="width:50px; border:1px solid #ddd; text-align:center">';
    };

    CodeGoods.formParams = function() {
        var queryData = {};
        queryData['module_id'] = $("#module_id").val();
        return queryData;
    };

    CodeGoods.check = function () {
        var selected = $('#' + this.id).bootstrapTable('getSelections');
        if(selected.length == 0){
            Feng.info("请先选中表格中的某一记录！");
            return false;
        }else{
            CodeGoods.seItem = selected[0];
            return true;
        }
    };

    CodeGoods.add = function () {
        var index = layer.open({type: 2,title: '创建菜单',area: ['900px', '100%'],fix: false, maxmin: true,content: 'info?action=add'});
        this.layerIndex = index;
    };

    CodeGoods.createCode = function(type) {
        if (this.check()) {
            var tip = '确定操作';
            var menu_id = this.seItem.menu_id;
            var is_create = this.seItem.is_create;
            if(is_create == 0){
                Feng.error("禁止生成模块！");
                return false;
            }
            var operation = function() {
                var ajax = new $ax(Feng.ctxPath + "/Build/create",
                    function(data) {
                        if ('00' === data.status) {
                            Feng.success(data.msg);
                        } else{
                            Feng.error(data.msg + "！", 10000);
                        }
                    });
                ajax.set("menu_id", menu_id);
                ajax.start();


            };
            Feng.confirm("是否" + tip, operation);
        }
    };

    CodeGoods.delete = function(value) {
        @if( config('my.drop_field_status')==1)
            var tip = '确定操作，数据表也会删除';
        @else
            var tip = '确定操作';
        @endif
                if(value){
                    Feng.confirm(tip, function () {
                        var ajax = new $ax(Feng.ctxPath + "/Menu/delete", function (data) {
                            if ('00' === data.status) {
                                Feng.success(data.msg);
                                CodeGoods.table.refresh();
                            } else {
                                Feng.error(data.msg);
                            }
                        });
                        ajax.set('menu_id', value);
                        ajax.start();
                    });
                }else{
                    if (this.check()) {
                        var menu_id = this.seItem.menu_id;
                        var operation = function() {
                            var ajax = new $ax(Feng.ctxPath + "/Menu/delete",
                                function(data) {
                                    if ('00' === data.status) {
                                        Feng.success(data.msg);
                                        CodeGoods.table.refresh();
                                    } else{
                                        Feng.error(data.msg + "！", 1000);
                                    }
                                });
                            ajax.set("menu_id", menu_id);
                            ajax.start();


                        };
                        Feng.confirm("是否" + tip, operation);
                    }
                }
            };

            CodeGoods.copyMenu = function(type) {
                if (this.check()) {
                    var tip = '确定操作';
                    var app_id = $("#copyMenuData").val();
                    var menu_id = this.seItem.menu_id;
                    var operation = function() {
                        var ajax = new $ax(Feng.ctxPath + "/Menu/copyMenu",
                            function(data) {
                                if ('00' === data.status) {
                                    Feng.success(data.msg);
                                    CodeGoods.table.refresh();
                                } else{
                                    Feng.error(data.msg + "！", 1000);
                                }
                            });
                        ajax.set("app_id", app_id);
                        ajax.set("menu_id", menu_id);
                        ajax.start();


                    };
                    Feng.confirm("是否" + tip, operation);
                }
            };

            CodeGoods.createMenuByTable = function(type) {
                var tip = '确定操作';
                var table_name = $("#tableData").val();
                if(!table_name){
                    Feng.error('请选择数据表', 1000);
                    return false;
                }
                var operation = function() {
                    var ajax = new $ax(Feng.ctxPath + "/Menu/createModuleByTable",
                        function(data) {
                            if ('00' === data.status) {
                                var ajax = new $ax(Feng.ctxPath + "/Build/create",
                                    function(data) {
                                        if ('00' === data.status) {
                                            Feng.success(data.msg);
                                            CodeGoods.table.refresh();
                                        } else{
                                            Feng.error(data.msg + "！", 10000);
                                        }
                                    });
                                ajax.set("menu_id", data.menu_id);
                                ajax.start();
                            } else{
                                Feng.error(data.msg + "！", 1000);
                            }
                        });
                    ajax.set("table_name", table_name);
                    ajax.start();
                };
                Feng.confirm("是否" + tip, operation);
            };

            CodeGoods.update = function (value) {
                if(value){
                    var index = layer.open({type: 2,title: '修改菜单',area: ['900px', '100%'],fix: false, maxmin: true,content: Feng.ctxPath + 'info?action=edit&menu_id='+value});
                }else{
                    if (this.check()) {
                        var idx = this.seItem.menu_id;
                        var index = layer.open({type: 2,title: '修改菜单',area: ['900px', '100%'],fix: false, maxmin: true,content: Feng.ctxPath + 'info?action=edit&menu_id='+idx});
                        this.layerIndex = index;
                    }
                }

            }


            CodeGoods.fieldlist = function () {
                if (this.check()) {
                    var idx = this.seItem.menu_id;
                    var name = this.seItem.title;
                    var index = layer.open({type: 2,title: name + ' 字段管理',area: ['99%', '99%'],fix: false, maxmin: true,content: Feng.ctxPath + '/Field/index?menu_id='+idx});
                    this.layerIndex = index;
                }
            }


            CodeGoods.actionlist = function () {
                if (this.check()) {
                    var idx = this.seItem.menu_id;
                    var name = this.seItem.title;
                    var index = layer.open({type: 2,title: name + ' 操作列表',area: ['99%', '99%'],fix: false, maxmin: true,content: Feng.ctxPath + '/Action/index?menu_id='+idx});
                    this.layerIndex = index;
                }
            }

            CodeGoods.arrowFormatter = function(value,row,index) {
                return '<i class="fa fa-long-arrow-up" onclick="CodeGoods.arrowsort('+value+',1)" style="cursor:pointer;" title="上移"></i>&nbsp;<i class="fa fa-long-arrow-down" style="cursor:pointer;" onclick="CodeGoods.arrowsort('+value+',2)"  title="下移"></i>';
            }

            CodeGoods.arrowsort = function (value,type) {
                var ajax = new $ax(Feng.ctxPath + "/Menu/arrowsort", function (data) {
                    if ('00' === data.status) {
                        Feng.success(data.msg);
                        CodeGoods.table.refresh();
                    } else {
                        Feng.error(data.msg);
                    }
                });
                ajax.set('menu_id', value);
                ajax.set('type', type);
                ajax.start();
            }

            CodeGoods.upsort = function(id,sortid)
            {
                var ajax = new $ax(Feng.ctxPath + "/Menu/setSort", function (data) {
                    if ('00' === data.status) {
                    } else {
                        Feng.error(data.msg);
                    }
                });
                ajax.set('sortid', sortid);
                ajax.set('id', id);
                ajax.start();
            }


            CodeGoods.search = function() {
                CodeGoods.table.refresh({query : CodeGoods.formParams()});
            };
</script>
@endsection
