<?php
namespace Database\Seeders;
use App\Models\Role;
use App\Models\User;
use Hash;
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
        ['identify'=>'admin','type'=>'username']
        );
        $admin->indents()->create(['identify'=>'admin@admin@com','user_id'=>$admin->id,'type'=>'email']);
        $adminRole = Role::all();
        $admin->syncRoles($adminRole);
    }
}
