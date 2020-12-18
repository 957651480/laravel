<?php

namespace Database\Seeders;

use App\Models\Sys\SysTree;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class SysTreeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //

        $data = [
            ['deep'=>1,'key' => 'table', 'name' => '数据表', 'value' => '', 'path' => 'table'],
            ['deep'=>2,'key' => 'user_ident', 'name' => '用户认证表', 'value' => '', 'path' => 'table,user_ident'],
            ['deep'=>3,'key' => 'login_type', 'name' => '登录类型', 'value' => '', 'path' => 'table,user_ident,login_type'],
            ['deep'=>4,'key' => 'phone', 'name' => '手机', 'value' => '', 'path' => 'table,user_ident,login_type,phone'],
        ];
        SysTree::insert($data);

        $updateArr=[];

        for($deep=1;$deep<10;$deep++){
            //上级
            $prev = SysTree::where('deep',$deep)->pluck('path','id')->toArray();
            if(!$prev){
                break;
            }
            //下级
            $next = SysTree::where('deep',$deep+1)->pluck('path','id')->toArray();
            if(!$next){
                break;
            }
            foreach ($next as $nid => $npath) {

                $pid=null;
                foreach ($prev as $id => $path) {

                    if(str_starts_with($npath,$path)){
                        $pid=$id;
                    }
                }
                if($pid){
                    $updateArr[]=[
                        'id'=>$nid,
                        'pid'=>$pid
                    ];
                }
            }
        }
        if($updateArr){
            SysTree::batchUpdate(new SysTree(),$updateArr,'id');
        }


    }
}
