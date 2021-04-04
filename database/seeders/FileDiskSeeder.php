<?php

namespace Database\Seeders;

use App\Models\File\Disk;
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
            ['key' => 'local', 'name' => '本地磁盘'],
            ['key' => 'qiniu', 'name' => '七牛云'],
            ['key' => 'alioss', 'name' => '阿里云'],
        ];
        Disk::insert($data);
    }
}
