<?php

namespace App\Livewire;

use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        return view('livewire.dashboard',['projects' => Project::count(),'tasks' => Task::count(),'users' => User::count()]);
    }
}
