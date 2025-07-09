<?php

namespace Database\Seeders;

use App\Models\Task;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class TasksUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $tasks1 = Task::find(1);
        $tasks2 = Task::find(2);
        $tasks3 = Task::find(3);

        if ($tasks1) {
            $tasks1->users()->syncWithoutDetaching([4, 5]);
        }

        if ($tasks2) {
            $tasks2->users()->syncWithoutDetaching([6, 7, 8]);
        }

        if ($tasks3) {
            $tasks3->users()->syncWithoutDetaching([8, 9]);
        }
    }
}
