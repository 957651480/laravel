<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        /*\App\Models\User::factory(1)->create([
            'name'=>'admin',
            'email'=>'admin@admin.com',
            'password' => Hash::make('admin123456'),
        ]);*/
        $this->call(PermissionSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(CategorySeeder::class);
        $this->call(ExcavatorCostSeeder::class);
    }
}
