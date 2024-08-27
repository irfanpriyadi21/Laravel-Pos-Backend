<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::factory(10)->create();
        User::create([
            "name" => 'Admin  Irfan',
            "email" => 'irfanpnf@gmail.com',
            "password" => Hash::make('12345678'),
            "roles" => 'ADMIN',
            "phone" => '085694118211'
        ]);
        //
    }
}
