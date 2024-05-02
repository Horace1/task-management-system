<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Models\Project;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateTask extends Component
{

    #[Validate('required|min:3|max:50', as: 'task name')]
    public string $name = '';
    #[Validate('required', as: "employee's")]
    public array $employees = [];
    #[Validate('required')]
    public string $status = '';
    #[Validate('required', as: 'project name')]
    public string $project_id = '';
    #[Validate('required|date|before_or_equal:end_date')]
    public string $start_date = '';
    #[Validate('required|date|after_or_equal:start_date')]
    public string $end_date = '';
    #[Validate('required|min:3|max:255')]
    public string $description = '';

    public $minStartDate;
    public $maxEndDate;

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

        $validated['employees'] = implode(" , ",$validated['employees']);

        Task::create($validated);

        Session::flash('success', 'Task saved successfully.');

        $this->reset();

        return $this->redirect('/tasks');
    }

    public function clearForm()
    {
        $this->reset(['name','project_id', 'start_date','end_date','description']);
    }

    public function render()
    {
        $users = User::whereIn('role_id', [2, 3])->get();
        return view('livewire.tasks.create-task',[
            'projects' => Project::all(),
            'task_employees' => $users->where('role_id', 3),
            'statuses' => TaskStatus::all() ]);
    }
}
