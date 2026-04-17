<?php

namespace App\Livewire\Employee;

use App\Livewire\Employee\Concerns\UpdatesAssignedTaskStatuses;
use App\Models\Project;
use App\Models\Task;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Dashboard extends Component
{
    use UpdatesAssignedTaskStatuses;

    public ?int $selectedProjectId = null;
    public bool $showProjectModal = false;

    public function viewProject(int $projectId): void
    {
        $this->selectedProjectId = $projectId;
        $this->showProjectModal = true;
    }

    public function closeProjectModal(): void
    {
        $this->reset(['selectedProjectId', 'showProjectModal']);
    }

    public function getSelectedProjectProperty(): ?Project
    {
        if (! $this->selectedProjectId) {
            return null;
        }

        return $this->selectedProjectQuery()->first();
    }

    protected function selectedProjectQuery(): Builder
    {
        $userId = auth()->id();

        return Project::query()
            ->where('id', $this->selectedProjectId)
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
            ]);
    }

    public function render()
    {
        $user = Auth::user();

        $tasksQuery = Task::query()
            ->whereHas('users', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            });

        $tasksCount = (clone $tasksQuery)->count();

        $upcomingDeadlines = (clone $tasksQuery)
            ->with('project')
            ->whereDate('end_date', '>=', now()->toDateString())
            ->orderBy('end_date')
            ->take(5)
            ->get();

        $recentTasks = (clone $tasksQuery)
            ->with(['project', 'taskStatus'])
            ->orderByDesc('updated_at')
            ->take(5)
            ->get();

        $projects = Project::query()
            ->whereHas('tasks.users', function ($query) use ($user) {
                $query->where('users.id', $user->id);
            })
            ->with(['manager', 'status'])
            ->with([
                'tasks' => function ($query) use ($user) {
                    $query->select('tasks.id', 'tasks.project_id', 'tasks.name')
                        ->whereHas('users', function ($subQuery) use ($user) {
                            $subQuery->where('users.id', $user->id);
                        })
                        ->orderBy('end_date');
                },
            ])
            ->orderByDesc('updated_at')
            ->get();

        return view('livewire.employee.dashboard', [
            'projects' => $projects,
            'projectsCount' => $projects->count(),
            'tasksCount' => $tasksCount,
            'upcomingDeadlines' => $upcomingDeadlines,
            'recentTasks' => $recentTasks,
        ]);
    }
}
