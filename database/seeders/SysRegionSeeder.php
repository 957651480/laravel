<?php

namespace Database\Seeders;

use App\Models\Sys\FileDisk;
use Illuminate\Database\Seeder;

class SysRegionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $data = [
            ['deep'=>1,'key' => 'table', 'name' => '数据表', 'value' => '', 'path' => 'table'],
            ['deep'=>2,'key' => 'user_ident', 'name' => '用户认证表', 'value' => '', 'path' => 'table,user_ident'],
            ['deep'=>3,'key' => 'login_type', 'name' => '登录类型', 'value' => '', 'path' => 'table,user_ident,login_type'],
            ['deep'=>4,'key' => 'phone', 'name' => '手机', 'value' => '', 'path' => 'table,user_ident,login_type,phone'],
            ['deep'=>4,'key' => 'email', 'name' => '邮箱', 'value' => '', 'path' => 'table,user_ident,login_type,email'],
            ['deep'=>4,'key' => 'weixin', 'name' => '微信', 'value' => '', 'path' => 'table,user_ident,login_type,weixin'],
        ];
        FileDisk::insert($data);

        $updateArr=[];
        $deep=1;
        $prev = FileDisk::where('deep',$deep)->pluck('path','id')->toArray();
        while ($prev){
            $deep++;
            $next = FileDisk::where('deep',$deep)->pluck('path','id')->toArray();
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
            $prev =$next;
        }
        if($updateArr){
            FileDisk::batchUpdate(new FileDisk(),$updateArr,'id');
        }
    }
}
