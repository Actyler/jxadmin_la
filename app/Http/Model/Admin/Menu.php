<?php

namespace App\Http\Model\Admin;

//use Illuminate\Database\Eloquent\Model;
//use Illuminate\Support\Facades\DB;
use App\Http\Model\BaseModel;

class Menu extends BaseModel
{
    protected $table = 'admin_menu';
    protected $primaryKey = 'menu_id';
    public $timestamps = true;


    public static function list($where=[],$limit='100',$field='*',$orderby='sort asc'){
        return Menu::select($field)->where($where)->orderByRaw($orderby)->limit($limit)->get();
    }

    public static function info($menu_id){
        return Menu::where(['menu_id'=>$menu_id])->first();
    }

    public static function setStatus($field,$id,$value){
        $data = [$field=>$value];

        try {
            $res = Menu::where(['menu_id'=>$id])->update($data);
            if($res)
                return ['status'=>1,'msg'=>'操作成功'];
            return ['status'=>-1,'msg'=>'操作失败'];
        }catch (\Exception $e){
            return ['status'=>-1,'msg'=>$e->getMessage()];
        }
    }

    public static function edit($data){
        $action = $data['action'];
        unset($data['action']);

        try {
            if($action == 'add') {
                unset($data['menu_id']);
                $res = Menu::insert($data);
            }else{
                $res = Menu::where(['menu_id'=>$data['menu_id']])->update($data);
            }
            if($res)
                return ['status'=>1,'msg'=>'操作成功'];
            return ['status'=>-1,'msg'=>'操作失败'];
        }catch (\Exception $e){
            return ['status'=>-1,'msg'=>$e->getMessage()];
        }
    }

    public static function del($id){
        $where = ['pid'=>$id];
        $num = Menu::where($where)->count();
        if($num>0)
            return ['status'=>-1,'msg'=>'存在子菜单'];
        try {
            $res = Menu::where($where)->delete();
            if($res)
                return ['status'=>1,'msg'=>'操作成功'];
            return ['status'=>-1,'msg'=>'操作失败'];
        }catch (\Exception $e){
            return ['status'=>-1,'msg'=>$e->getMessage()];
        }

    }
}
