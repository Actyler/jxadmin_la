<?php

namespace App\Http\Controllers\Admin;

use App\Http\Model\Admin\Menu;
use Illuminate\Support\Facades\DB;

class LayoutController extends AdminBaseController
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('guest:admin')->except(['logout']);
    }

    public function layout(){
        $menu = $this->getMenuTree();
        return view('admin.layout.layout',['menu'=>$menu]);
    }

    public function welcome(){
        return '欢迎';
    }

    public function login(){
        return view('admin.layout.login');
    }


}
