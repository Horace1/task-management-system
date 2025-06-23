<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProjectStatus;

class ProjectStatusSeeder extends Seeder
{
    public function run(): void
    {
        $statuses = [
            'Pending',
            'In Progress',
            'Paused',
            'Completed',
        ];

        foreach ($statuses as $name) {
            ProjectStatus::firstOrCreate(['name' => $name]);
        }
    }
}
