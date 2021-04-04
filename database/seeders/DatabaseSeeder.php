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
            'nickname'=>'admin',
            'password' => Hash::make('admin123456'),
        ]);*/
        $this->call(SysTreeSeeder::class);
        $this->call(FileDiskSeeder::class);

    }
}
