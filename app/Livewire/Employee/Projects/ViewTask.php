<?php

namespace App\Livewire\Employee\Projects;

use App\Livewire\Employee\Concerns\UpdatesAssignedTaskStatuses;
use App\Models\Task;
use Livewire\Component;

class ViewTask extends Component
{
    use UpdatesAssignedTaskStatuses;

    public int $id;

    public function mount($id): void
    {
        $this->id = (int) $id;
    }

    public function render()
    {
        $userId = auth()->id();

        $task = Task::query()
            ->where('id', $this->id)
            ->whereHas('users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->with(['project', 'taskStatus', 'users'])
            ->firstOrFail();

        return view('livewire.employee.projects.view-task', [
            'task' => $task,
        ]);
    }
}
