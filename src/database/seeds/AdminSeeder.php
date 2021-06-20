<?php

use Illuminate\Database\Seeder;
use App\User;
class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create(
            [
                'name'     => 'admin',
                'email'    => 'admin@admin.com',
                'isAdmin'  => 1 ,
                'password' =>Hash::make(123456) ,
                'phone'    => '011111111'
            ]
            );
    }
}