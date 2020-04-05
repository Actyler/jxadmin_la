<?php

namespace App\Http\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class Menu extends Model
{
    protected $table = 'admin_menu';
    protected $primaryKey = 'menu_id';
    public $timestamps = false;

    public static function menuList($where=[],$limit='100',$field='*',$orderby='sort asc'){
        return Menu::select($field)->where($where)->orderByRaw($orderby)->limit($limit)->get();
    }

    public static function menuInfo($menu_id){
        return Menu::where(['menu_id'=>$menu_id])->first();
    }

    public static function setStatus($field,$id,$value){
        $time = time();
        try {
            $res = Menu::where(['menu_id'=>$id])->update([$field=>$value,'update_time'=>$time]);
            if($res)
                return ['status'=>1,'msg'=>'操作成功'];
            return ['status'=>-1,'msg'=>'操作失败'];
        }catch (\Exception $e){
            return ['status'=>-1,'msg'=>$e->getMessage()];
        }
    }

    public static function edit($data){
        $time = time();
        $action = $data['action'];
        unset($data['action']);
        $data['update_time'] = $time;
        try {
            if($action == 'add') {
                unset($data['menu_id']);
                $data['create_time'] = $time;
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
