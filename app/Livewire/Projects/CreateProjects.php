<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\ProjectStatus;
use App\Models\User;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Validate;
use Livewire\Component;

class CreateProjects extends Component
{
    #[Validate('required|min:3|max:50', as: 'project name')]
    public string $name = '';
    #[Validate('required', as: 'project status')]
    public string $project_status_id = '';
    #[Validate('required')]
    public string $project_manager = '';
    #[Validate('required', as: "employee's")]
    public array $employees = [];
    #[Validate('required|date|after:yesterday')]
    public string $start_date = '';
    #[Validate('required|date|after_or_equal:start_date')]
    public string $end_date = '';
    #[Validate('required|min:3|max:255')]
    public string $description = '';


    public function save()
    {
        $validated = $this->validate();

        $validated['employees'] = implode(" , ",$validated['employees']);

        $validated['user_id'] = $this->project_manager;

        Project::create($validated);

        Session::flash('success', 'Project saved successfully.');

        $this->reset();

        return $this->redirect('/projects');
    }

    public function clearForm()
    {
        $this->reset(['name','project_manager','project_status_id','employees','start_date','end_date','description']);
    }

    public function render()
    {
        $users = User::whereIn('role_id', [2, 3])->get();

        return view('livewire.projects.create-projects', [
            'project_managers' => $users->where('role_id', 2),
            'project_employees' => $users->where('role_id', 3),
            'statuses' => ProjectStatus::all()
        ]);
    }
}
