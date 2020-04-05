var CodeInfoDlg = {
	CodeInfoData: {},
	deptZtree: null,
	pNameZtree: null,
	validateFields: {
		title: {
			validators: {
				notEmpty: {
					message: '菜单标题不能为空'
	 			}
	 		}
	 	},
		controller: {
			validators: {
				regexp: {
					regexp: /^[0-9a-zA-Z/]+$/,
					message: '大小写字母组合'
	 			},
	 		}
	 	},
		table: {
			validators: {
				regexp: {
					regexp: /^[a-zA-Z_0-9]+$/,
					message: '大小写字母组合'
	 			},
	 		}
	 	},
		pk: {
			validators: {
				regexp: {
					regexp: /^[a-zA-Z_]+$/,
					message: '大小写字母组合'
	 			},
	 		}
	 	}

	 }
}


CodeInfoDlg.clearData = function () {
	 this.CodeInfoData = {};
};


CodeInfoDlg.set = function (key, val) {
	 this.CodeInfoData[key] = (typeof value == "undefined") ? $("#" + key).val() : value;
	 return this;
};


CodeInfoDlg.get = function (key) {
	 return $("#" + key).val();
};


CodeInfoDlg.close = function () {
	 var index = parent.layer.getFrameIndex(window.name);
	 parent.layer.close(index);
};


CodeInfoDlg.collectData = function () {
	this.set('action').set('menu_id').set('title').set('controller').set('table').set('pk').set('sort').set('pid').set('url').set('icon').set('tab_menu');
};


CodeInfoDlg.icon = function () {
		var index = layer.open({type: 2,title: '设置图标',area: ['800px', '500px'],fix: false, maxmin: true,content: Feng.ctxPath + '/Base/icon/field/menu_icon'});
		this.layerIndex = index;
}


CodeInfoDlg.submit = function () {
	 this.clearData();
	 this.collectData();
	 if (!this.validate()) {
	 	return;
	 }

	 var is_create = $("input[name = 'is_create']:checked").val();
	 var level = $("#pid option:selected").data('level');
	 var is_table = $("input[name = 'is_table']:checked").val();
	 var status = $("input[name = 'status']:checked").val();
	 var is_submit = $("input[name = 'is_submit']:checked").val();

     var is_url = 0;
	 if(this.CodeInfoData['url'] !== ''){
         is_url = 1;
     }

	 console.log($("#pid option:selected").val());

	 if(this.CodeInfoData['pid'] === ''){
	     this.CodeInfoData['pid'] = 0
	     level = 0;
     }else{
	     level += 1;
     }

	 var tip = $("input[name='action']")==='add'?'添加':'编辑';
	 var ajax = new $ax("info", function (data) {
	 	if (data.status === 1) {
	 		Feng.success(tip + "成功" );
	 		window.parent.CodeGoods.table.refresh();
	 		CodeInfoDlg.close();
	 	} else {
	 		Feng.error(tip + "失败！" + data.msg + "！");
		 }
	 }, function (data) {
	 	Feng.error("操作失败!" + data.msg + "!");
	 });
	 ajax.set('is_create',is_create);
	 ajax.set('level',level);
	 ajax.set('is_url',is_url);
	 ajax.set('is_table',is_table);
	 ajax.set('status',status);
	 ajax.set('is_submit',is_submit);
	 ajax.set(this.CodeInfoData);
	 ajax.start();
};

CodeInfoDlg.validate = function () {
	  $('#CodeInfoForm').data("bootstrapValidator").resetForm();
	  $('#CodeInfoForm').bootstrapValidator('validate');
	  return $("#CodeInfoForm").data('bootstrapValidator').isValid();
};


$(function () {
	   Feng.initValidator("CodeInfoForm", CodeInfoDlg.validateFields);
});


