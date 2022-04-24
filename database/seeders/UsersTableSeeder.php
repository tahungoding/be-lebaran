<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = new User;
        $user->fullname = "admin";
        $user->username = "admin";
        $user->email = "admin@mail.com";
        $user->password = bcrypt('password'); 
        $user->role = "admin";
        $user->save();
    }
}
