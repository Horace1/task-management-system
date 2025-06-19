<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Silber\Bouncer\BouncerFacade as Bouncer;

class BouncerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $admin = Bouncer::role()->firstOrCreate(
            ['name' => 'admin'],
            ['title' => 'Admin']
        );

        $project_manager = Bouncer::role()->firstOrCreate(
            ['name' => 'project-manager'],
            ['title' => 'Project Manager']
        );

        $employee = Bouncer::role()->firstOrCreate(
            ['name' => 'employee'],
            ['title' => 'Employee']
        );

        $abilities = [
            // Projects
            ['name' => 'create-project', 'title' => 'Create Project'],
            ['name' => 'edit-project', 'title' => 'Edit Project'],
            ['name' => 'view-project', 'title' => 'View Single Project'],
            ['name' => 'view-projects', 'title' => 'View All Projects'],
            ['name' => 'delete-project', 'title' => 'Delete Project'],

            // Tasks
            ['name' => 'create-task', 'title' => 'Create Task'],
            ['name' => 'edit-task', 'title' => 'Edit Task'],
            ['name' => 'view-task', 'title' => 'View Task'],
            ['name' => 'view-tasks', 'title' => 'View All Tasks'],
            ['name' => 'delete-task', 'title' => 'Delete Task'],

            // Users
            ['name' => 'create-user', 'title' => 'Create User'],
            ['name' => 'edit-user', 'title' => 'Edit User'],
            ['name' => 'view-user', 'title' => 'View User'],
            ['name' => 'view-users', 'title' => 'View All Users'],
            ['name' => 'delete-user', 'title' => 'Delete User'],
        ];

        foreach ($abilities as $ability) {
            Bouncer::ability()->firstOrCreate([
                'name' => $ability['name']
            ], [
                'title' => $ability['title']
            ]);
        }

        Bouncer::allow($admin)->everything();

        Bouncer::allow($project_manager)->to([
            'create-project',
            'edit-project',
            'view-projects',
            'view-project',
            'create-task',
            'edit-task',
            'view-task',
            'view-tasks',
            'create-user',
            'edit-user',
            'view-user',
            'view-users',
            'delete-user',
        ]);

        Bouncer::allow($employee)->to([
            'view-projects',
            'view-project',
            'view-task',
            'view-tasks',
        ]);

    }
}
