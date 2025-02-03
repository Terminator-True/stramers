<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        $user = User::create([
            'name' => 'Admin',
            'nick'=> 'admin',
            'email' => 'admin@stramers.com',
            'password'=>Hash::make('Admin@123'),
            'money' => 999999,
            'superadmin' => 1,
            'background_profile' => 1,
        ]);
    $user->backgrounds()->attach([1]);
    $user->cards()->attach([4,7,8]);
    $user->changeStatus(1);

    }
}
