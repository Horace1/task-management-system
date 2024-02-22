<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Models\Project;
use Livewire\Component;

class EditTask extends Component
{
    public $id;
    public $name;
    public $project_id;
    public $start_date;
    public $end_date;
    public $description;

    public $minStartDate;
    public $maxEndDate;

    public $validationAttributes = [
        'project_id' => 'project',
    ];

    public function rules()
    {
        return [
            'name' => 'required|min:3|max:50',
            'project_id' => 'required',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'required|min:3|max:255',
        ];
    }

    public function messages()
    {
        return [
            'start_date.before_or_equal' => 'The start date must be before or equal to the end date.',
            'end_date.after_or_equal' => 'The end date must be after or equal to the start date.',
        ];
    }

    public function mount($id)
    {
        $this->id = $id;
        $task = Task::find($id);
        $this->name = $task->name;
        $this->project_id = $task->project_id;
        $this->start_date = $task->start_date;
        $this->end_date = $task->end_date;
        $this->description = $task->description;
        $project = Project::find($this->project_id);
        $this->minStartDate = $project->start_date;
        $this->maxEndDate = $project->end_date;
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
