<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User();
        $user->name = 'shourab';
        $user->email = 'shourab.cit.bd@gmail.com';
        $user->password = Hash::make('password');
        $user->save();
        $user->assignRole('admin');

        $user = new User();
        $user->name = 'test';
        $user->email = 'test@gmail.com';
        $user->password = Hash::make('password');
        $user->save();
        $user->assignRole('user');
    }
}
