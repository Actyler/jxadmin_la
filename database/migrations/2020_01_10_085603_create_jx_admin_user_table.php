<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
//use Illuminate\Support\Facades\Schema;
use Jialeo\LaravelSchemaExtend\Schema;

class CreateJxAdminUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin', function (Blueprint $table) {
            $table->comment = '后台管理员账户';
            $table->bigIncrements('id');
            $table->string('username',255)->comment('用户名');
            $table->string('email',255)->comment('邮箱');
            $table->string('password',255)->comment('密码');
            $table->string('head_pic',255)->nullable()->comment('头像');
            $table->tinyInteger('status')->default(1)->comment("状态 0禁用 1启用");
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
        Schema::dropIfExists('admin');
    }
}
