<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ViewProjects extends Component
{
    use WithPagination;

    public string $search = '';

    public $sortStartDate = 'asc';

    public $sortEndDate = 'asc';

    public $showModal = false;

    public $mode = 'create';

    public $selectedProject = null;

    public $selectedManager = '';


    public $managers = [];

    public $form = [
        'id' => null,
        'name' => '',
        'project_manager' => '',
        'start_date' => '',
        'end_date' => '',
        'description' => '',
    ];

    public function mount()
    {
        $this->managers = User::whereHas('roles', function ($query) {
            $query->where('name', 'project-manager');
        })->orderBy('first_name')->orderBy('last_name')->get();
    }

    public function create()
    {
        $this->reset('form');
        $this->mode = 'create';
        $this->showModal = true;
    }

    public function edit($projectId)
    {
        $project = Project::findOrFail($projectId);

        $this->form = [
            'id' => $project->id,
            'name' => $project->name,
            'project_manager' => $project->user_id,
            'start_date' => $project->start_date,
            'end_date' => $project->end_date,
            'description' => $project->description,
        ];
        $this->mode = 'edit';
        $this->showModal = true;
    }

    public function view($projectId)
    {
        $this->selectedProject = Project::with('manager')->findOrFail($projectId);
        $this->mode = 'view';
        $this->showModal = true;
    }

    protected function rules()
    {
        return [
            'form.name' => 'required|min:3|max:50',
            'form.project_manager' => auth()->user()->isAn('admin') ? 'required|exists:users,id' : 'nullable|exists:users,id',
            'form.start_date' => 'required|date',
            'form.end_date' => 'required|date|after_or_equal:form.start_date',
            'form.description' => 'required|min:3|max:255',
        ];
    }

    public function save()
    {
        $this->validate();

        if (!auth()->user()->isAn('admin')) {
            $this->form['project_manager'] = auth()->id();
        }

        if ($this->mode === 'create') {
            Project::create([
                'name' => $this->form['name'],
                'user_id' => $this->form['project_manager'],
                'start_date' => $this->form['start_date'],
                'end_date' => $this->form['end_date'],
                'description' => $this->form['description'],
                'progress' => 0,
                'project_status_id' => 1,
            ]);

            session()->flash('message', 'Project created successfully.');
        } elseif ($this->mode === 'edit') {
            $project = Project::findOrFail($this->form['id']);

            $project->update([
                'name' => $this->form['name'],
                'user_id' => $this->form['project_manager'],
                'start_date' => $this->form['start_date'],
                'end_date' => $this->form['end_date'],
                'description' => $this->form['description'],
            ]);

            session()->flash('message', 'Project updated successfully.');
        }

        $this->showModal = false;
        $this->mode = 'create';
        $this->reset('form', 'selectedProject');
    }

    public function getStartDateSortLabelProperty()
    {
        return 'Start Date ' . ($this->sortStartDate === 'asc' ? 'Ascending' : 'Descending');
    }


    public function delete($id)
    {
        $project = Project::findOrFail($id);
        $project->delete();

        session()->flash('message', 'Project deleted successfully.');
    }

    public function render()
    {
        $projects = Project::query()
            ->with('manager')
            ->withCount('tasks')
            ->where('name', 'like', "%" . $this->search . "%")
            ->when($this->selectedManager, function ($query) {
                return $query->where('user_id', $this->selectedManager);
            })
            ->orderBy('start_date', $this->sortStartDate)
            ->orderBy('end_date', $this->sortEndDate)
            ->paginate(10);

        return view('livewire.projects.view-projects', ['projects' => $projects]);
    }
}
