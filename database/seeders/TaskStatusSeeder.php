<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\TaskStatus;

class TaskStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            'Pending',
            'In Progress',
            'Paused',
            'Done',
        ];

        foreach ($statuses as $name) {
            TaskStatus::firstOrCreate(['name' => $name]);
        }
    }
}
