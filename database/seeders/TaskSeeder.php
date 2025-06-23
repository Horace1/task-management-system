<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Seeder;

class TaskSeeder extends Seeder
{

    public function run(): void
    {

        $projectIds = [1, 2, 3];

        foreach ($projectIds as $projectId) {
            Task::firstOrCreate(
                [
                    'name' => 'Task for Project ' . $projectId,
                    'project_id' => $projectId,
                ],
                [
                    'task_status_id' => 1,
                    'start_date' => '2024-02-22',
                    'end_date' => '2024-03-25',
                    'description' => 'Task for project ' . $projectId,
                ]
            );
        }
    }
}
