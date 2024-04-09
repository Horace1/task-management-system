<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Role::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Admin'
            ]
        );

        Role::firstOrCreate(
            ['id' => 2],
            [
                'name' => 'Project Manager'
            ]
        );

        Role::firstOrCreate(
            ['id' => 3],
            [
                'name' => 'Employee'
            ]
        );
    }
}
