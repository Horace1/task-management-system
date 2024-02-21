<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;

class EditProjects extends Component
{

    public $id;
    public $name;
    public $start_date;
    public $end_date;
    public $description;

    protected $rules = [
        'name' => 'required|min:3|max:50',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
        'description' => 'required|min:3|max:255',
    ];

    public function mount($id)
    {
        $this->id = $id;
        $project = Project::find($id);
        $this->name = $project->name;
        $this->start_date = $project->start_date;
        $this->end_date = $project->end_date;
        $this->description = $project->description;
    }

    public function update()
    {
        $this->validate();

        Project::find($this->id)->update([
            'name' => $this->name,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'description' => $this->description,
        ]);

        $this->redirect('/projects');
    }

    public function clearForm()
    {
        $this->reset(['name', 'start_date', 'end_date', 'description']);
    }

    public function render()
    {
        return view('livewire.projects.edit-projects', ['project' => Project::find($this->id)]);
    }
}
