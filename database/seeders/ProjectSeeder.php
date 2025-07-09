<?php

namespace Database\Seeders;

use App\Models\Project;
use Illuminate\Database\Seeder;

class ProjectSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $projects = [
            [
                'name' => 'Project 1',
                'user_id' => 2,
                'start_date' => '2024-02-20',
                'end_date' => '2024-02-25',
                'description' => 'This is project 1 description',
                'progress' => 10,
                'project_status_id' => 1
            ],
            [
                'name' => 'Project 2',
                'user_id' => 2,
                'start_date' => '2024-02-20',
                'end_date' => '2024-02-25',
                'description' => 'This is project 2 description',
                'progress' => 30,
                'project_status_id' => 1
            ],
            [
                'name' => 'Project 3',
                'user_id' => 3,
                'start_date' => '2024-02-20',
                'end_date' => '2024-02-25',
                'description' => 'This is project 3 description',
                'progress' => 100,
                'project_status_id' => 1
            ],
            [
                'name' => 'Project 4',
                'user_id' => 3,
                'start_date' => '2024-02-20',
                'end_date' => '2024-02-25',
                'description' => 'This is project 4 description',
                'progress' => 100,
                'project_status_id' => 1
            ],
        ];

        foreach ($projects as $project) {
            Project::firstOrCreate(
                ['name' => $project['name']],
                $project
            );
        }
    }
}
