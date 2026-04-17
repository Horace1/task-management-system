<?php

namespace App\Livewire\Employee\Concerns;

use App\Models\Task;
use App\Models\TaskStatus;
use Illuminate\Database\Eloquent\Collection;

trait UpdatesAssignedTaskStatuses
{
    public function getTaskStatusesProperty(): Collection
    {
        return TaskStatus::query()
            ->orderBy('name')
            ->get();
    }

    public function updateTaskStatus(int $taskId, int $statusId): void
    {
        TaskStatus::query()->findOrFail($statusId);

        $task = Task::query()
            ->whereKey($taskId)
            ->whereHas('users', function ($query) {
                $query->where('users.id', auth()->id());
            })
            ->firstOrFail();

        $task->update([
            'task_status_id' => $statusId,
        ]);

        session()->flash('message', 'Task status updated successfully.');
    }
}
