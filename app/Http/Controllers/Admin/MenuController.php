<?php
namespace App\Http\Controllers\Admin;

use App\Http\Model\Menu;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class MenuController extends AdminBaseController
{
    public function index(){
        if(request()->isMethod('post')){
            $menu = $this->formatMenu($this->getMenuTree());
            return response()->json(['rows'=>$menu,'total'=>sizeof($menu)]);
        }else{
            return view('admin.menu.index');
        }
    }

    public function info(Request $request){
        $input = $request->post();
        if(request()->ajax()){
            return response()->json(Menu::edit($input));
        }else{
            $menu_list = $this->formatMenu($this->getMenuTree());
            $assign = ['menu_list'=>$menu_list, 'action'=>$input['action']];
            if($input['action'] == 'edit'){
                $menu_id = $request->input('menu_id');
                $info = Menu::menuInfo($menu_id);
                $assign['info'] = $info;
            }
            return view('admin.menu.info',$assign);
        }
    }

    public function edit(Request $request){
        if(request()->isMethod('ajax')){
            dd(1);
        }else{
            $menu_id = $request->input('menu_id');
            $info = Menu::menuInfo($menu_id);
            $menu_list = $this->formatMenu($this->getMenuTree());
            return view('admin.menu.info',['menu_list'=>$menu_list, 'info'=>$info, 'action'=>'edit']);
        }
    }

    public function setStatus(Request $request){
        $field = $request->input('field');
        $id = $request->input('menu_id');
        $value = $request->input('value');

        return response()->json(Menu::setStatus($field,$id,$value));
    }

    //格式化菜单
    private function formatMenu($menu,$data=[]){
        foreach ($menu as $key => $value){
            $pre = '';
            for ($i=0; $i<$value->level; $i++){
                $pre .= " ├─ ";
            }

            $value->ctitle = $pre . $value->title;
            array_push($data,$value);
            if(isset($value->child)){
                $data = $this->formatMenu($value->child,$data);
            }
        }
        return $data;
    }

}
