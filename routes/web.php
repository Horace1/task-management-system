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

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {

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
