<?php

namespace App\Livewire\Employee\Projects;

use App\Livewire\Employee\Concerns\UpdatesAssignedTaskStatuses;
use App\Models\Project;
use Illuminate\Database\Eloquent\Builder;
use Livewire\Component;
use Livewire\WithPagination;

class ViewProjects extends Component
{
    use WithPagination;
    use UpdatesAssignedTaskStatuses;

    public string $search = '';
    public string $sortStartDate = 'asc';
    public string $sortEndDate = 'asc';
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
        $userId = auth()->id();

        $projects = Project::query()
            ->whereHas('tasks.users', function ($query) use ($userId) {
                $query->where('users.id', $userId);
            })
            ->with(['manager', 'status'])
            ->with([
                'tasks' => function ($query) use ($userId) {
                    $query->select('tasks.id', 'tasks.project_id', 'tasks.name')
                        ->whereHas('users', function ($subQuery) use ($userId) {
                            $subQuery->where('users.id', $userId);
                        })
                        ->orderBy('end_date');
                },
            ])
            ->where('name', 'like', '%' . $this->search . '%')
            ->orderBy('start_date', $this->sortStartDate)
            ->orderBy('end_date', $this->sortEndDate)
            ->paginate(10);

        return view('livewire.employee.projects.view-projects', [
            'projects' => $projects,
        ]);
    }
}
