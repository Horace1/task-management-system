<?php

namespace App\Livewire;

use App\Models\ProjectStatus;
use Illuminate\Support\Facades\Auth;
use App\Models\Project;
use App\Models\Task;
use App\Models\User;
use Livewire\Component;
use Silber\Bouncer\BouncerFacade as Bouncer;

class Dashboard extends Component
{

    public $user = '';
    public $statusCounts = [];
    public $tasksPerProject = [];
    public $userRoles = [];
    public $teamMembersPerProject = [];
    public $editRecentProjectId = null;

    public $editProjectId = null;
    public $testProjectId = null;

    public $name = '';
    public $description = '';
    public $start_date = '';
    public $end_date = '';
    public $project_status_id = '';
    public $project_manager = '';
    public $employees = [];
    public $project_id = '';


    public function mount()
    {

        $this->user = Auth::user();

        if ($this->user->isAn('admin')) {
            $this->statusCounts = Project::selectRaw('project_status_id, COUNT(*) as count')
                ->groupBy('project_status_id')
                ->with('status')
                ->get()
                ->mapWithKeys(fn($row) => [$row->status->name => $row->count])
                ->toArray();

            $this->tasksPerProject = Project::withCount('tasks')
                ->orderByDesc('tasks_count')
                ->take(5)
                ->get()
                ->mapWithKeys(fn($project) => [$project->name => $project->tasks_count])
                ->toArray();

            $this->userRoles = User::with('roles')
                ->get()
                ->map(function ($user) {
                    return $user->roles->first()?->name ?? 'Unknown'; // safely get 1 role
                })
                ->countBy()
                ->toArray();

        } elseif ($this->user->isA('project-manager')) {

            $this->statusCounts = Project::where('user_id', $this->user->id)
                ->selectRaw('project_status_id, COUNT(*) as count')
                ->groupBy('project_status_id')
                ->with('status')
                ->get()
                ->mapWithKeys(fn($row) => [$row->status->name => $row->count])
                ->toArray();

            $this->tasksPerProject = Project::where('user_id', $this->user->id)
                ->withCount('tasks')
                ->orderByDesc('tasks_count')
                ->take(5)
                ->get()
                ->mapWithKeys(fn($project) => [$project->name => $project->tasks_count])
                ->toArray();

            $this->teamMembersPerProject = Project::with(['tasks.users'])
                ->where('user_id', $this->user->id)
                ->get()
                ->mapWithKeys(function ($project) {
                    $employeeCount = $project->tasks
                        ->flatMap->users
                        ->filter(fn($user) => Bouncer::is($user)->a('employee'))
                        ->unique('id')
                        ->count();

                    return [$project->name => $employeeCount];
                })
                ->toArray();
        }
    }

//    public function updatedEditProjectId($id)
//    {
//
//        $project = Project::find($id);
//
//        if ($project) {
//            $this->name = $project->name;
//            $this->description = $project->description;
//            $this->start_date = $project->start_date;
//            $this->end_date = $project->end_date;
//            $this->project_status_id = $project->project_status_id;
//            $this->project_manager = $project->user_id;
//        }
//
//    }

    public function confirmDelete($projectId)
    {
        $project = Project::findOrFail($projectId);
        $project->delete();

        session()->flash('message', 'Project deleted successfully.');
    }

    public function render()
    {

        $projects = $this->user->isAn('admin') ? Project::count() : $this->user->projects()->count();
        $tasks = $this->user->isAn('admin') ? Task::count() : Task::whereIn('project_id', $this->user->projects()->pluck('id'))->count();

        if ($this->user->isAn('admin')) {
            $users = User::count();
        } else {
            $employeesPerProject = Project::with(['tasks.users'])
                ->where('user_id', $this->user->id)
                ->get()
                ->mapWithKeys(function ($project) {
                    $employeeCount = $project->tasks
                        ->flatMap->users
                        ->filter(fn($user) => Bouncer::is($user)->a('employee'))
                        ->unique('id')
                        ->count();

                    return [$project->name => $employeeCount];
                })
                ->toArray();

            $users = array_sum($employeesPerProject);

        }

        $recent_projects = collect();

        if ($this->user->isAn('admin')) {
            $recent_projects = Project::latest()
                ->take(5)
                ->with(['manager', 'status'])
                ->get();
        } elseif ($this->user->isA('project-manager')) {
            $recent_projects = Project::where('user_id', $this->user->id)
                ->latest()
                ->take(5)
                ->with(['status', 'tasks.users'])
                ->get();
        }

        $statuses = ProjectStatus::all();

        return view('livewire.dashboard', [
            'projects' => $projects,
            'tasks' => $tasks,
            'users' => $users,
            'recentProjects' => $recent_projects,
            'statuses' => $statuses,
            'userRoles' => $this->userRoles,
        ]);
    }

}
