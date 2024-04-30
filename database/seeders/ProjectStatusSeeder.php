<?php

namespace Database\Seeders;

use App\Models\ProjectStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProjectStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        ProjectStatus::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Pending'
            ]
        );

        ProjectStatus::firstOrCreate(
            ['id' => 2],
            [
                'name' => 'In progress'
            ]
        );

        ProjectStatus::firstOrCreate(
            ['id' => 3],
            [
                'name' => 'Paused'
            ]
        );

        ProjectStatus::firstOrCreate(
            ['id' => 4],
            [
                'name' => 'Completed'
            ]
        );
    }
}
