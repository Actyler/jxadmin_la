<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
//use Illuminate\Support\Facades\Schema;
use Jialeo\LaravelSchemaExtend\Schema;

class AdminMenu extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        //创建后台管理菜单表
        Schema::create('admin_menu',function (Blueprint $table){
            $table->comment = "后台管理菜单";
            $table->increments('menu_id');
            $table->unsignedInteger('pid')->comment('父级id');
            $table->string('controller','64')->nullable()->comment('模块控制器');
            $table->string('title','64')->default('')->comment('模块标题');
            $table->string('pk','33')->nullable()->comment('表主键名');
            $table->tinyInteger('is_create')->default(0)->comment('是否生成代码 0否 1是');
            $table->tinyInteger('is_table')->default(0)->comment('是否创建数据库表 0否 1是');
            $table->string('table')->default('')->nullable()->comment('数据库表名');
            $table->tinyInteger('is_url')->default(0)->comment('是否是链接 0否 1是');
            $table->string('url',255)->nullable();
            $table->string('icon',64)->nullable()->comment('菜单图标');
            $table->unsignedTinyInteger('level')->default(0)->comment('菜单等级');
            $table->string('tab_menu',500)->nullable()->comment('Tab栏菜单 |分隔');
            $table->tinyInteger('is_submit')->default(1)->comment('是否允许提交 0否 1是');
            $table->tinyInteger('has_time')->default(1)->comment('是否包含创建与修改时间 0否 1是');
            $table->unsignedMediumInteger('sort')->default(0)->comment('排序');
            $table->tinyInteger('status')->default(1)->comment('启用状态 0禁用 1启用');
            $table->unsignedInteger('create_time')->nullable();
            $table->unsignedInteger('update_time')->nullable();
        });

        //创建后台字段管理表
        Schema::create('admin_field',function (Blueprint $table){
            $table->comment = '数据表字段管理';
            $table->increments('field_id');
            $table->unsignedInteger('menu_id')->comment('菜单id');
            $table->string('name',64)->comment('字段名');
            $table->string('field',64)->comment('字段');
            $table->tinyInteger('is_field')->default(0)->comment('是否为字段');
            $table->tinyInteger('type')->default(1)->comment('表单类型1输入框 2下拉框 3单选框 4多选框 5上传图片 6编辑器 7时间');
            $table->tinyInteger('list_show')->default(0)->comment('列表显示');
            $table->tinyInteger('search_show')->default(0)->comment('搜索显示');
            $table->tinyInteger('search_type')->default(1)->comment('1精确搜索 2模糊搜索');
            $table->string('config',255)->nullable()->comment('下拉框或者单选框配置');
            $table->tinyInteger('is_write')->default(1)->comment('是否前段录入');
            $table->string('note',255)->nullable()->comment('提示信息');
            $table->string('message',255)->nullable()->comment('错误提示');
            $table->string('validate',32)->nullable()->comment('验证方式');
            $table->mediumText('rule')->nullable()->comment('验证规则');
            $table->unsignedMediumInteger('sort')->default(100)->comment('排序');
            $table->string('sql',255)->nullable()->comment('数据源sql');
            $table->string('tab_menu',50)->nullable()->comment('所属Tab栏');
            $table->string('datatype')->comment('数据类型');
            $table->string('default_value')->nullable()->comment('默认值');
            $table->string('length')->nullable()->comment('字段长度 decimal使用,分隔');
            $table->string('index_data',20)->nullable()->comment('索引');
            $table->unsignedInteger('create_time')->nullable()->comment('创建时间');
            $table->unsignedInteger('update_time')->nullable()->comment('更新时间');
        });

    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_menu');
        Schema::dropIfExists('admin_field');
    }
}
