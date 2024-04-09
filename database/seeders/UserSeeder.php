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
        User::firstOrCreate(
            ['id' => 1],
            [
                'first_name' => 'Horace',
                'last_name' => 'Benjamin',
                'contact_number' => '123456789',
                'email' => 'horacebenjamin84@googlemail.com',
                'password' => Hash::make('Anthonyb1'),
                'role_id' => 1,
            ],
        );

        User::firstOrCreate(
            ['id' => 2],
            [
                'first_name' => 'John',
                'last_name' => 'Doe',
                'contact_number' => '123456789',
                'email' => 'johndoe84@googlemail.com',
                'password' => Hash::make('JohnDoe1'),
                'role_id' => 2,
            ],
        );

        User::firstOrCreate(
            ['id' => 3],
            [
                'first_name' => 'Jane',
                'last_name' => 'Doe',
                'contact_number' => '123456789',
                'email' => 'janedoe84@googlemail.com',
                'password' => Hash::make('JaneDoe1'),
                'role_id' => 3,
            ],
        );
    }
}
