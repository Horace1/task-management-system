<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Models\Project;
use Livewire\Component;

class CreateTask extends Component
{

    public $name;
    public $project_id;
    public $start_date;
    public $end_date;
    public $description;

    public function rules()
    {
        return [
            'name' => 'required|min:3|max:50',
            'project_id' => 'required',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'description' => 'required|min:3|max:255',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        Task::create($validated);
        $this->reset();

        return $this->redirect('/tasks');
    }

    public function clearForm()
    {
        $this->reset(['name','project_id', 'start_date','end_date','description']);
    }

    public function render()
    {
        return view('livewire.tasks.create-task',['projects' => Project::all()]);
    }
}
