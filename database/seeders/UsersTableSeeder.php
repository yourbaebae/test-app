<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class UsersTableSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();
        DB::table('users')->insert([
            'name'  => 'Laurent Perrier',
            'email' =>  'laurent@quiz.com',
            'position'  =>  'Projects Manager',
            'password'  => Hash::make('123456')
        ]);
    }
}
