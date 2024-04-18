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
            ['id' => 1],
            [
                'name' => 'admin',
                'title' => 'Admin',
            ]
        );

        $project_manager = Bouncer::role()->firstOrCreate(
            ['id' => 2],
            [
                'name' => 'project-manager',
                'title' => 'Project Manager',
            ]
        );

        $employee = Bouncer::role()->firstOrCreate(
            ['id' => 3],
            [
                'name' => 'employee',
                'title' => 'Employee',
            ]
        );

        $create_project = Bouncer::ability()->firstOrCreate([
            'name' => 'create-project',
            'title' => 'Create Project',
        ]);

        $edit_project = Bouncer::ability()->firstOrCreate([
            'name' => 'edit-project',
            'title' => 'Edit Project',
        ]);

        $view_project = Bouncer::ability()->firstOrCreate([
            'name' => 'view-project',
            'title' => 'View Project',
        ]);

        $view_projects = Bouncer::ability()->firstOrCreate([
            'name' => 'view-projects',
            'title' => 'View Projects',
        ]);

        $delete_task = Bouncer::ability()->firstOrCreate([
            'name' => 'view-task',
            'title' => 'View Project',
        ]);

        $create_task = Bouncer::ability()->firstOrCreate([
            'name' => 'create-task',
            'title' => 'Create Project',
        ]);

        $edit_task = Bouncer::ability()->firstOrCreate([
            'name' => 'edit-task',
            'title' => 'Edit Project',
        ]);

        $view_tasks = Bouncer::ability()->firstOrCreate([
            'name' => 'view-task',
            'title' => 'View Project',
        ]);

        $delete_tasks = Bouncer::ability()->firstOrCreate([
            'name' => 'view-task',
            'title' => 'View Project',
        ]);


        Bouncer::allow($admin)->everything();
        Bouncer::allow($project_manager)->to();
        Bouncer::allow($employee)->to();
    }
}
