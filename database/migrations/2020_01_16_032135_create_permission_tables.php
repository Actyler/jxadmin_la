<?php

//use Illuminate\Support\Facades\Schema;
use Jialeo\LaravelSchemaExtend\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreatePermissionTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        $tableNames = config('permission.table_names');
        $columnNames = config('permission.column_names');

        Schema::create($tableNames['permissions'], function (Blueprint $table) {
            $table->comment = '方法权限';
            $table->bigIncrements('id');
            $table->string('guard_name')->default('admin')->comment('模块');
            $table->unsignedInteger('menu_id')->comment('模块id');
            $table->string('name')->comment('权限方法');
            $table->string('title')->comment('权限标题');
            $table->tinyInteger('type')->comment('方法类型');
            $table->string('icon',32)->nullable()->comment('图标');
            $table->unsignedTinyInteger('pagesize')->default(20)->comment('每页显示数量');
            $table->tinyInteger('is_view')->default(1)->comment('是否显示按钮');
            $table->tinyInteger('list_show')->default(1)->comment('是否在列表显示');
            $table->mediumText('sql_query')->nullable()->comment('sql数据源');
            $table->string('block_name',255)->nullable()->comment('操作显示内容');
            $table->string('remark',255)->nullable()->comment('注释');
            $table->mediumText('fields')->nullable()->comment('操作字段');
            $table->string('note',255)->nullable()->comment('备注');
            $table->string('label_color',255)->nullable()->comment('按钮背景色');
            $table->string('relate_table',255)->nullable()->comment('关联表');
            $table->string('relate_field',255)->nullable()->comment('关联字段');
            $table->mediumText('list_field')->nullable()->comment('查询字段');
            $table->string('bs_icon')->nullable()->comment('按钮图标');
            $table->mediumInteger('sort')->default(100)->comment('排序');
            $table->string('orderby',255)->nullable()->comment('排序规则');
            $table->string('default_orderby',255)->nullable()->comment('默认排序');
            $table->string('tree_config',50)->nullable()->comment('');
            $table->string('url',255)->nullable()->comment('跳转地址');
            $table->tinyInteger('is_controller_create')->default(0)->comment('是否生成控制器方法');
            $table->tinyInteger('is_service_create')->default(0)->comment('是否生成服务层方法');
            $table->tinyInteger('is_view_create')->default(0)->comment('是否生成视图');
            $table->mediumInteger('cache_time')->default(60)->comment('缓存时间');
            $table->tinyInteger('log_status')->default(0)->comment('是否生成缓存');
            $table->string('request_type',20)->nullable()->comment('请求类型');
            $table->string('do_condition',50)->nullable()->comment('操作条件');
            $table->tinyInteger('is_permission')->default(1)->comment('是否需要鉴权');
            $table->timestamps();
        });

        Schema::create($tableNames['roles'], function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name')->comment('名称');
            $table->string('guard_name')->default('admin');
            $table->tinyInteger('status')->default(1)->comment('状态 0禁用 1启用');
            $table->timestamps();
        });

        Schema::create($tableNames['model_has_permissions'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedBigInteger('permission_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_permissions_model_id_model_type_index');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->primary(['permission_id', $columnNames['model_morph_key'], 'model_type'],
                    'model_has_permissions_permission_model_type_primary');
        });

        Schema::create($tableNames['model_has_roles'], function (Blueprint $table) use ($tableNames, $columnNames) {
            $table->unsignedBigInteger('role_id');

            $table->string('model_type');
            $table->unsignedBigInteger($columnNames['model_morph_key']);
            $table->index([$columnNames['model_morph_key'], 'model_type'], 'model_has_roles_model_id_model_type_index');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['role_id', $columnNames['model_morph_key'], 'model_type'],
                    'model_has_roles_role_model_type_primary');
        });

        Schema::create($tableNames['role_has_permissions'], function (Blueprint $table) use ($tableNames) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');

            $table->foreign('permission_id')
                ->references('id')
                ->on($tableNames['permissions'])
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on($tableNames['roles'])
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id'], 'role_has_permissions_permission_id_role_id_primary');
        });

        app('cache')
            ->store(config('permission.cache.store') != 'default' ? config('permission.cache.store') : null)
            ->forget(config('permission.cache.key'));
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        $tableNames = config('permission.table_names');

        Schema::drop($tableNames['role_has_permissions']);
        Schema::drop($tableNames['model_has_roles']);
        Schema::drop($tableNames['model_has_permissions']);
        Schema::drop($tableNames['roles']);
        Schema::drop($tableNames['permissions']);
    }
}
