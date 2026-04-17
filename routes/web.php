<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\Projects\ViewProjects;
use App\Livewire\Tasks\ViewTasks;
use App\Livewire\Users\ViewUsers;
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
            return redirect()->route('dashboard');
        }

        if ($user->isAn('employee')) {
            return redirect()->route('employee.dashboard');
        }

        return abort(403, 'Unauthorized');
    })->name('redirect-login');

    // Admin + Project Manager
    Route::middleware('role:admin,project-manager')->group(function () {
        Route::get('/dashboard', Dashboard::class)->name('dashboard');
        Route::get('/projects', ViewProjects::class)->name('view-projects');
        Route::get('/tasks', ViewTasks::class)->name('view-tasks');
        Route::get('/users', ViewUsers::class)->name('view-users');
    });

    // Employee only
    Route::middleware('role:employee')
        ->prefix('employee')
        ->name('employee.')
        ->group(function () {
            Route::get('/dashboard', EmployeeDashboard::class)->name('dashboard');
            Route::get('/projects', EmployeeProjects::class)->name('projects');
            Route::get('/projects/{id}', EmployeeProject::class)->name('view-project');
            Route::get('/tasks', EmployeeTasks::class)->name('tasks');
            Route::get('/tasks/{id}', EmployeeTask::class)->name('view-task');
        });
});
