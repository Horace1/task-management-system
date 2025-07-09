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
        $users = [
            [
                'first_name' => 'Admin',
                'last_name' => 'Admin',
                'email' => 'admin@admin.com',
                'password' => 'admin123',
            ],
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'email' => 'johndoe@googlemail.com',
                'password' => 'JohnDoe1',
            ],
            [
                'first_name' => 'Tom',
                'last_name' => 'Smith',
                'email' => 'tomsmith@googlemail.com',
                'password' => 'TomSmith1',
            ],
            [
                'first_name' => 'Jane',
                'last_name' => 'Doe',
                'email' => 'janedoe@googlemail.com',
                'password' => 'JaneDoe1',
            ],
            [
                'first_name' => 'Tim',
                'last_name' => 'West',
                'email' => 'timwest@googlemail.com',
                'password' => 'TimWest1',
            ],
            [
                'first_name' => 'Anna',
                'last_name' => 'West',
                'email' => 'annawest@googlemail.com',
                'password' => 'AnnaWest1',
            ],
            [
                'first_name' => 'Paul',
                'last_name' => 'Watson',
                'email' => 'paulwatson@googlemail.com',
                'password' => 'PaulWatson1',
            ],
            [
                'first_name' => 'Dwayne',
                'last_name' => 'Mclaren',
                'email' => 'dwaynemclaren@googlemail.com',
                'password' => 'DwayneMclaren1',
            ],
            [
                'first_name' => 'Marvin',
                'last_name' => 'Wilson',
                'email' => 'marvinwilson@googlemail.com',
                'password' => 'MarvinWilson1',
            ],
        ];

        foreach ($users as $data) {
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'first_name' => $data['first_name'],
                    'last_name' => $data['last_name'],
                    'contact_number' => '123456789',
                    'password' => Hash::make($data['password']),
                ]
            );
        }

    }
}
