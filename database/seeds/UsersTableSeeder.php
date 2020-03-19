<?php

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
        DB::table('users')->truncate();
        DB::table('users')->insert([
            'name'      => 'user',
            'email'     => 'user@email.com',
            'password'  => Hash::make('password'),
        ]);
    }
}
