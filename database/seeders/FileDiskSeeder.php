<?php

namespace Database\Seeders;

use App\Models\Sys\SysTree;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class FileDiskSeeder extends Seeder
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
        ];
        SysTree::insert($data);

        $updateArr=[];
        $deep=1;
    }
}
