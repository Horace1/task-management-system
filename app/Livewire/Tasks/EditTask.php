<?php

namespace App\Livewire\Tasks;

use App\Models\Project;
use App\Models\Task;
use Livewire\Component;

class EditTask extends Component
{
    public $id;
    public $name;
    public $project_id;
    public $start_date;
    public $end_date;
    public $description;

    protected $rules = [
        'name' => 'required|min:3|max:50',
        'project_id' => 'required',
        'start_date' => 'required|date',
        'end_date' => 'required|date',
        'description' => 'required|min:3|max:255',
    ];

    public function mount($id)
    {
        $this->id = $id;
        $task = Task::find($id);
        $this->name = $task->name;
        $this->project_id = $task->project_id;
        $this->start_date = $task->start_date;
        $this->end_date = $task->end_date;
        $this->description = $task->description;
    }

    public function update()
    {
        $this->validate();

        Task::find($this->id)->update([
            'name' => $this->name,
            'project_id' => $this->project_id,
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
        return view('livewire.tasks.edit-task', ['task' => Task::find($this->id),'projects' => Project::all()]);
    }
}
