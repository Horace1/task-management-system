<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProjectStatus;

class ProjectStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            'Not Started',
            'Pending',
            'In Progress',
            'Completed',
        ];

        foreach ($statuses as $name) {
            ProjectStatus::firstOrCreate(['name' => $name]);
        }
    }
}
