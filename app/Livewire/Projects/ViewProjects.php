<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;

class ViewProjects extends Component
{
    public function render()
    {
        $projects = Project::all();
        return view('livewire.projects.view-projects', ['projects' => $projects]);
    }
}
