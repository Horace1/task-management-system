<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Assuming there are projects with ids 1 and 2 in the projects table
        $projects = [
            ['id' => 1],
            ['id' => 2],
            ['id' => 3],
        ];

        foreach ($projects as $project) {
            Task::firstOrCreate(
                ['id' => $project['id']], // Use project id as the task id
                [
                    'name' => 'Task for Project ' . $project['id'],
                    'project_id' => $project['id'],
                    'employees' => 'jane Doe',
                    'status' => 1,
                    'start_date' => '2024-02-22',
                    'end_date' => '2024-03-25',
                    'description' => 'Task for project ' . $project['id'],
                ]
            );
        }
    }
}
