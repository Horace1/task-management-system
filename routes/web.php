<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\Projects\ViewProjects;
use App\Livewire\Projects\ViewProject;
use App\Livewire\Projects\EditProject;
use App\Livewire\Projects\CreateProjects;
use App\Livewire\Tasks\ViewTasks;
use App\Livewire\Tasks\ViewTask;
use App\Livewire\Tasks\EditTask;
use App\Livewire\Tasks\CreateTask;
use App\Livewire\Users\ViewUsers;
use App\Livewire\Users\ViewUser;
use App\Livewire\Users\EditUser;
use App\Livewire\Users\CreateUser;

use App\Livewire\Employee\Dashboard as EmployeeDashboard;
use App\Livewire\Employee\Projects\ViewProjects as EmployeeProjects;
use App\Livewire\Employee\Projects\ViewProject as EmployeeProject;
use App\Livewire\Employee\Projects\ViewTasks as EmployeeTasks;
use App\Livewire\Employee\Projects\ViewTask as EmployeeTask;


Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

    Route::get('/redirect-login', function () {
        $user = auth()->user();

        if ($user->isAn('admin') || $user->isAn('project-manager')) {
            return redirect()->route('dashboard'); // /dashboard
        }

        if ($user->isAn('employee')) {
            return redirect()->route('employee.dashboard'); // /employee/dashboard
        }

        // fallback
        return abort(403, 'Unauthorized');
    });

    // Admin + Project Manager
    Route::middleware('role:admin,project-manager')->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');

        Route::get('/projects', ViewProjects::class)->name('view-projects');
        Route::get('/edit-project/{id}', EditProject::class)->name('edit-project');
        Route::get('/view-project/{id}', ViewProject::class)->name('view-project');
        Route::get('/create-projects', CreateProjects::class)->name('create-projects');

        Route::get('/tasks', ViewTasks::class)->name('view-tasks');
        Route::get('/edit-task/{id}', EditTask::class)->name('edit-task');
        Route::get('/view-task/{id}', ViewTask::class)->name('view-task');
        Route::get('/create-task', CreateTask::class)->name('create-task');

        Route::get('/users', ViewUsers::class)->name('view-users');
        Route::get('/edit-user/{id}', EditUser::class)->name('edit-user');
        Route::get('/view-user/{id}', ViewUser::class)->name('view-user');
        Route::get('/create-user', CreateUser::class)->name('create-user');
    });

    // Employee only
    Route::middleware('role:employee')
        ->prefix('employee')
        ->name('employee.')
        ->group(function () {
            Route::get('/dashboard', EmployeeDashboard::class)->name('dashboard');
            Route::get('/projects', EmployeeProjects::class)->name('projects');
            Route::get('/view-project/{id}', EmployeeProject::class)->name('view-project');
            Route::get('/tasks', EmployeeTasks::class)->name('tasks');
            Route::get('/view-task/{id}', EmployeeTask::class)->name('view-task');
        });

});
