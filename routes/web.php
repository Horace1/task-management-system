<?php

use Illuminate\Support\Facades\Route;
use App\Livewire\Dashboard;
use App\Livewire\Projects\ViewProjects;
use App\Livewire\Projects\ViewProject;
use App\Livewire\Projects\EditProjects;
use App\Livewire\Projects\CreateProjects;

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
    Route::get('/edit-projects/{id}', EditProjects::class)->name('edit-projects');
    Route::get('/view-project/{id}', ViewProject::class)->name('view-project');
    Route::get('/create-projects', CreateProjects::class)->name('create-projects');

});
