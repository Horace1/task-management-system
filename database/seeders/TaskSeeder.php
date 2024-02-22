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
        Task::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Task 1',
                'project_id' => '1',
                'start_date' => '2024/02/22',
                'end_date' => '2024/03/25',
                'description' => 'Task 1 for project 1'
            ]
        );

        Task::firstOrCreate(
            ['id' => 2],
            [
                'name' => 'Task 2',
                'project_id' => '2',
                'start_date' => '2024/02/22',
                'end_date' => '2024/03/25',
                'description' => 'Task 2 for project 1'
            ]
        );

        Task::firstOrCreate(
            ['id' => 3],
            [
                'name' => 'Task 3',
                'project_id' => '1',
                'start_date' => '2024/02/22',
                'end_date' => '2024/03/25',
                'description' => 'Task 3 for project 1'
            ]
        );
    }
}
