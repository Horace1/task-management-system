<?php

namespace App\Livewire\Employee\Projects;

use App\Livewire\Employee\Concerns\UpdatesAssignedTaskStatuses;
use App\Models\Project;
use Livewire\Component;

class ViewProject extends Component
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

        $project = Project::query()
            ->where('id', $this->id)
            ->whereHas('tasks.users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->with(['manager', 'status'])
            ->with([
                'tasks' => function ($query) use ($userId) {
                    $query->whereHas('users', function ($subQuery) use ($userId) {
                        $subQuery->where('users.id', $userId);
                    })
                    ->with(['taskStatus'])
                    ->orderBy('end_date');
                },
            ])
            ->firstOrFail();

        return view('livewire.employee.projects.view-project', [
            'project' => $project,
        ]);
    }
}
