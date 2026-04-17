<?php

namespace App\Livewire\Tasks;

use App\Models\Project;
use App\Models\Task;
use App\Models\TaskStatus;
use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ViewTasks extends Component
{
    use WithPagination;

    public $search = '';
    public $sortStartDate = 'asc';
    public $sortEndDate = 'asc';

    public $showModal = false;
    public $mode = 'create';
    public $selectedTask = null;

    public $projects = [];
    public $users = [];
    public $taskStatuses = [];

    public $form = [
        'id' => null,
        'name' => '',
        'project_id' => '',
        'users' => [],
        'start_date' => '',
        'end_date' => '',
        'description' => '',
        'task_status_id' => 1, // Default to first status (likely "To Do" or "Not Started")
    ];

    public function mount()
    {
        $this->projects = Project::orderBy('name')->get();
        $this->users = User::whereHas('roles', function ($query) {
            $query->where('name', 'employee');
        })->orderBy('first_name')->orderBy('last_name')->get();
        $this->taskStatuses = TaskStatus::orderBy('name')->get();

        if ($this->taskStatuses->isNotEmpty()) {
            $this->form['task_status_id'] = $this->taskStatuses->first()->id;
        }
    }

    public function create()
    {
        $this->reset('form');

        if ($this->taskStatuses->isNotEmpty()) {
            $this->form['task_status_id'] = $this->taskStatuses->first()->id;
        }

        $this->form['start_date'] = now()->format('Y-m-d');
        $this->form['end_date'] = now()->addDays(7)->format('Y-m-d');
        $this->mode = 'create';
        $this->showModal = true;
    }

    public function edit($taskId)
    {
        $task = Task::with('users')->findOrFail($taskId);
        $this->form = [
            'id' => $task->id,
            'name' => $task->name,
            'project_id' => $task->project_id,
            'users' => $task->users->pluck('id')->toArray(),
            'start_date' => $task->start_date,
            'end_date' => $task->end_date,
            'description' => $task->description,
            'task_status_id' => $task->task_status_id,
        ];
        $this->mode = 'edit';
        $this->showModal = true;
    }

    public function view($taskId)
    {
        $this->selectedTask = Task::with(['project', 'users', 'taskStatus'])->findOrFail($taskId);
        $this->mode = 'view';
        $this->showModal = true;
    }

    protected function rules()
    {
        return [
            'form.name' => 'required|min:3|max:50',
            'form.project_id' => 'required',
            'form.users' => 'required|array|min:1',
            'form.task_status_id' => 'required|exists:task_statuses,id',
            'form.start_date' => 'required|date',
            'form.end_date' => 'required|date|after_or_equal:form.start_date',
            'form.description' => 'required|min:3|max:255',
        ];
    }

    public function save()
    {
        $this->validate();

        if ($this->mode === 'create') {
            $task = Task::create([
                'name' => $this->form['name'],
                'project_id' => $this->form['project_id'],
                'start_date' => $this->form['start_date'],
                'end_date' => $this->form['end_date'],
                'description' => $this->form['description'],
                'task_status_id' => $this->form['task_status_id'],
            ]);

            $task->users()->sync($this->form['users']);

            session()->flash('message', 'Task created successfully.');
        } elseif ($this->mode === 'edit') {
            $task = Task::findOrFail($this->form['id']);
            $task->update([
                'name' => $this->form['name'],
                'project_id' => $this->form['project_id'],
                'start_date' => $this->form['start_date'],
                'end_date' => $this->form['end_date'],
                'description' => $this->form['description'],
                'task_status_id' => $this->form['task_status_id'],
            ]);

            $task->users()->sync($this->form['users']);

            session()->flash('message', 'Task updated successfully.');
        }

        $this->showModal = false;
        $this->mode = 'create';
        $this->reset('form', 'selectedTask');
    }

    public function delete($id)
    {
        $task = Task::findOrFail($id);
        $task->delete();

        session()->flash('message', 'Task deleted successfully.');
    }

    public function render()
    {
        return view('livewire.tasks.view-tasks', [
            'tasks' => Task::query()
                ->with(['project', 'users', 'taskStatus'])
                ->where('name', 'like', "%" . $this->search . "%")
                ->orderBy('start_date', $this->sortStartDate)
                ->orderBy('end_date', $this->sortEndDate)
                ->paginate(10)
        ]);
    }
}
