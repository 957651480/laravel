<?php

use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run( User $users)
    {

        $admin = $users->createUser([
            'nickname'=>'admin',
            'password' => Hash::make('admin123456'),
        ],
        ['identify'=>'admin','type'=>10]
        );
        $admin->indents()->create(['identify'=>'admin@admin@com','user_id'=>$admin->id,'type'=>20]);
        $adminRole = Role::all();
        $admin->syncRoles($adminRole);
    }
}
