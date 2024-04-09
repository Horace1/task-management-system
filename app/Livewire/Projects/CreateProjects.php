<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\User;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreateProjects extends Component
{
    #[Rule('required|min:3|max:50')]
    public $name;

    #[Rule('required')]
    public $Project_manager;

    #[Rule('required|date|after:today')]
    public $start_date;

    #[Rule('required|date|after:today')]
    public $end_date;

    #[Rule('required|min:3|max:255')]
    public $description;

    public function save()
    {
        $validated = $this->validate();
        $validated['user_id'] = $this->Project_manager;
        Project::create($validated);
        $this->reset();

        return $this->redirect('/projects');
    }

    public function clearForm()
    {
        $this->reset(['name','project_manager','start_date','end_date','description']);
    }

    public function render()
    {
        $project_managers = User::where('role_id',2)->get();
        return view('livewire.projects.create-projects',['project_managers' => $project_managers]);
    }
}
