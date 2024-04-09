<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Project::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Project 1',
                'user_id' => '2',
                'start_date' => '2024/02/20',
                'end_date' => '2024/02/25',
                'description' => 'This is project 1 description'
            ]
        );

        Project::firstOrCreate(
            ['id' => 2],
            [
                'name' => 'Project 2',
                'user_id' => '2',
                'start_date' => '2024/02/20',
                'end_date' => '2024/02/25',
                'description' => 'This is project 2 description'
            ]
        );

        Project::firstOrCreate(
            ['id' => 3],
            [
                'name' => 'Project 3',
                'user_id' => '2',
                'start_date' => '2024/02/20',
                'end_date' => '2024/02/25',
                'description' => 'This is project 3 description'
            ]
        );
    }
}
