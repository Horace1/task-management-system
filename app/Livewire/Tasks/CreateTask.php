<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Models\Project;
use App\Models\User;
use Livewire\Component;

class CreateTask extends Component
{

    public $name;
    public $employee;
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
            'employee' => 'required',
            'project_id' => 'required',
            'start_date' => 'required|date|before_or_equal:end_date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'description' => 'required|min:3|max:255',
        ];
    }

    public function attributes()
    {
        return [
            'project_id' => 'Project',
        ];
    }

    public function messages()
    {
        return [
            'start_date.before_or_equal' => 'The start date must be before or equal to the end date.',
            'end_date.after_or_equal' => 'The end date must be after or equal to the start date.',
        ];
    }

    public function updatedProjectId()
    {
        $project = Project::find($this->project_id);
        if ($project) {
            $this->minStartDate = $project->start_date;
            $this->maxEndDate = $project->end_date;
        }
    }

    public function save()
    {
        $validated = $this->validate();
        $validated['user_id'] = $this->employee;
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
        $employees = User::where('role_id',3)->get();
        return view('livewire.tasks.create-task',['projects' => Project::all(), 'employees' => $employees]);
    }
}
