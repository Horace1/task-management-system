<?php

namespace App\Livewire;

use App\Models\Project;
use Livewire\Component;

class Projects extends Component
{
    public function render()
    {
        $projects = Project::all();
        return view('livewire.projects', ['projects' => $projects]);
    }
}
