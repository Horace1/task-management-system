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
    return view('welcome');
});

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
//    Route::get('/dashboard', function () {
//        return view('dashboard');
//    })->name('dashboard');

    Route::get('/dashboard', Dashboard::class)->name('dashboard');

    Route::get('/projects', ViewProjects::class)->name('view-projects');
    Route::get('/edit-project/{id}', EditProject::class)->name('edit-project');
    Route::get('/view-project/{id}', ViewProject::class)->name('view-project');
    Route::get('/create-projects', CreateProjects::class)->name('create-projects');

    Route::get('/tasks', ViewTasks::class)->name('view-tasks');
    Route::get('/edit-task/{id}', EditTask::class)->name('edit-task');
    Route::get('/view-task/{id}', ViewTask::class)->name('view-task');
    Route::get('/create-task', CreateTask::class)->name('create-task');

});
