<?php

namespace App\Livewire\Employee\Projects;

use App\Livewire\Employee\Concerns\UpdatesAssignedTaskStatuses;
use App\Models\Task;
use Livewire\Component;
use Livewire\WithPagination;

class ViewTasks extends Component
{
    use WithPagination;
    use UpdatesAssignedTaskStatuses;

    public string $search = '';
    public string $sortStartDate = 'asc';
    public string $sortEndDate = 'asc';

    public function render()
    {
        $userId = auth()->id();

        $tasks = Task::query()
            ->with(['project', 'taskStatus'])
            ->whereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->where(function ($query) {
                $query->where('name', 'like', '%' . $this->search . '%')
                    ->orWhereHas('project', function ($projectQuery) {
                        $projectQuery->where('name', 'like', '%' . $this->search . '%');
                    });
            })
            ->orderBy('start_date', $this->sortStartDate)
            ->orderBy('end_date', $this->sortEndDate)
            ->paginate(10);

        return view('livewire.employee.projects.view-tasks', [
            'tasks' => $tasks,
        ]);
    }
}
