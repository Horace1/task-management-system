<?php

namespace Database\Seeders;

use App\Models\TaskStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TaskStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        TaskStatus::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Pending'
            ]
        );

        TaskStatus::firstOrCreate(
            ['id' => 2],
            [
                'name' => 'In progress'
            ]
        );

        TaskStatus::firstOrCreate(
            ['id' => 3],
            [
                'name' => 'Paused'
            ]
        );

        TaskStatus::firstOrCreate(
            ['id' => 4],
            [
                'name' => 'Done'
            ]
        );
    }
}
