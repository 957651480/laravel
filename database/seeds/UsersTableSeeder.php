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
    public function run()
    {

        $admin = User::create([
            'name'=>'admin',
            'email'=>'admin@admin@com',
            'password' => Hash::make('admin123456'),
        ]);
        $admin->idents()->create([
            'identify'=>'admin',
            'type'=>10,
            'user_id'=>$admin->id
        ]);

        $adminRole = Role::all();
        $admin->syncRoles($adminRole);
    }
}
