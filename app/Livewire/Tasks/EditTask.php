<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use App\Models\Project;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditTask extends Component
{
    public $id;
    #[Validate('required|min:3|max:50')]
    public string $name = '';
    #[Validate('required', as: "employee's")]
    public array $employees;
    #[Validate('required')]
    public string $status = '';
    #[Validate('required', as: 'project')]
    public string $project_id = '';
    #[Validate('required|date|before_or_equal:end_date', message: 'The start date must be before or equal to the end date.')]
    public string $start_date = '';
    #[Validate('required|date|after_or_equal:start_date', message: 'The end date must be after or equal to the start date.')]
    public string $end_date = '';
    #[Validate('required|min:3|max:255')]
    public string $description = '';

    public $minStartDate;
    public $maxEndDate;

    public function mount($id)
    {
        $this->id = $id;
        $task = Task::find($id);
        $this->name = $task->name;
        $this->project_id = $task->project_id;
        $this->employees = explode(",", $task->employees);
        $this->status = $task->status;
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
            'employees' => implode(",", $this->employees),
            'status' => $this->status,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'description' => $this->description,
        ]);

        Session::flash('success', 'Task updated successfully.');

        $this->redirect('/tasks');
    }

    public function clearForm()
    {
        $this->reset(['name', 'start_date', 'end_date', 'description']);
    }

    public function render()
    {
        $users = User::whereIn('role_id', [2, 3])->get();
        return view('livewire.tasks.edit-task', [
            'task' => Task::find($this->id),
            'task_employees' => $users->where('role_id', 3),
            'statuses' => TaskStatus::all(),
            'projects' => Project::all()]);
    }
}
