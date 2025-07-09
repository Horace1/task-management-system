<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaskStatus;

class TaskStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            'Not Started',
            'Pending',
            'In Progress',
            'Done',
        ];

        foreach ($statuses as $name) {
            TaskStatus::firstOrCreate(['name' => $name]);
        }
    }
}
