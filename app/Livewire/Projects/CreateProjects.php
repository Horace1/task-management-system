<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Attributes\Rule;
use Livewire\Component;

class CreateProjects extends Component
{
    #[Rule('required|min:3|max:50')]
    public $name;

    #[Rule('required|date|after:today')]
    public $start_date;

    #[Rule('required|date|after:today')]
    public $end_date;

    #[Rule('required|min:3|max:255')]
    public $description;

    public function save()
    {
        $validated = $this->validate();
        Project::create($validated);
        $this->reset();

        return $this->redirect('/projects');
    }

    public function clearForm()
    {
        $this->reset(['name', 'start_date','end_date','description']);
    }

    public function render()
    {
        return view('livewire.projects.create-projects');
    }
}
