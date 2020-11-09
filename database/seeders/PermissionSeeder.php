<?php

namespace Database\Seeders;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $permission = Permission::create(
            ['name' => 'edit_article','display_name'=>'编辑文章']
        );

        $superRole = Role::create(['name' => 'admin','display_name'=>'管理员']);

        $permission->assignRole($superRole);
    }
}
