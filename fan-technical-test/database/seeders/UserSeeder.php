<?php

namespace Database\Seeders;

use Cartalyst\Sentinel\Laravel\Facades\Sentinel;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            'nama'              => "Ananda Bayu",
            'email'             => "bayu@email.com",
            'npp'               => "12345",
            'npp_supervisor'    => "11111",
            'password'          => "password",
        ];

        $user2 = [
            'nama'              => "Supervisor",
            'email'             => "spv@email.com",
            'npp'               => "11111",
            'password'          => "password",
        ];

        Sentinel::register($user);
        Sentinel::register($user2);
    }
}
