<?php
namespace Database;

use App\Http\Model\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Permission;

class Seeds extends Seeder
{
    //composer dump-autoload 很重要

    private $permissions = [
        [
            'name' => 'admin-user.index'
        ]
    ];

    private $menus = [
        ['menu_id'=>1,'pid'=>0, 'title' => '系统管理', 'level'=>0, 'sort'=>9999,'is_url'=>0, 'url'=>''],
        ['menu_id'=>2,'pid'=>1, 'title' => '菜单管理', 'level'=>1, 'is_url'=>1, 'url'=>'admin/menu/index', 'sort'=>0],
        ['menu_id'=>3,'pid'=>1, 'title' => '用户管理', 'level'=>1, 'sort'=>0,'is_url'=>0, 'url'=>''],
        ['menu_id'=>4,'pid'=>1, 'title' => '分组管理', 'level'=>1, 'sort'=>0,'is_url'=>0, 'url'=>'']
    ];

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->createAdminUser();
        $this->createPermission();
    }

    //创建超级管理员
    private function createAdminUser(){
        $time = time();
        Admin::truncate();
        Admin::insert([
            'username'      =>      'admin',
            'email'         =>      'admin@gmail.com',
            'password'      =>      Hash::make('000000'),
            'status'        =>      1,
            'create_time'   =>      $time,
            'update_time'   =>      $time
        ]);
    }

    //创建权限
    private function createPermission(){
        DB::table('admin_menu')->truncate();
        DB::table('admin_menu')->insert($this->menus);

        foreach ($this->permissions as $permission) {
            $permission['guard_name'] = 'admin';
            Permission::create($permission);
        }

    }
}
