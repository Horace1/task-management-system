<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\TaskStatus;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Validate;
use Livewire\Component;

class EditProject extends Component
{
    public $id;
    #[Validate('required|min:3|max:50')]
    public $name;
    #[Validate('required')]
    public $status;
    #[Validate('required')]
    public $project_manager;
    #[Validate('required')]
    public $employees;
    #[Validate('required|date')]
    public $start_date;
    #[Validate('required|date')]
    public $end_date;
    #[Validate('required|min:3|max:255')]
    public $description;

    public $validationAttributes = [
        'name' => 'project name',
        'employees' => "employee's",
    ];

    public function mount($id)
    {
        $this->id = $id;
        $project = Project::find($id);
        $employees = explode(" , ",$project->employees);
        $this->name = $project->name;
        $this->status = $project->project_status_id;
        $this->project_manager = $project->user_id;
        $this->employees = $employees;
        $this->start_date = $project->start_date;
        $this->end_date = $project->end_date;
        $this->description = $project->description;
    }

    public function update()
    {
        $this->validate();

        $employees = implode(" , ",$this->employees);

        Project::find($this->id)->update([
            'name' => $this->name,
            'status' => $this->status,
            'project_manager' => $this->project_manager,
            'employees' => $employees,
            'start_date' => $this->start_date,
            'end_date' => $this->end_date,
            'description' => $this->description,
        ]);

        Session::flash('success', 'Project updated successfully.');

        $this->redirect('/projects');
    }

    public function clearForm()
    {
        $this->reset(['name', 'start_date', 'end_date', 'description']);
    }

    public function render()
    {
        $users = User::whereIn('role_id', [2, 3])->get();

        return view('livewire.projects.edit-project',
            [
                'project_managers' => $users->where('role_id', 2),
                'project_employees' => $users->where('role_id', 3),
                'statuses' => ProjectStatus::all()

            ]);
    }
}
