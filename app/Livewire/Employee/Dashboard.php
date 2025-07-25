<?php

namespace App\Livewire\Employee;

use Livewire\Component;

class Dashboard extends Component
{
    public function render()
    {
        $user = \Auth::user();

        return view('livewire.employee.dashboard', [
            'projects' => $user->projects,
            'tasks' => $user->tasks,
            'upcomingDeadlines' => $user->tasks()->whereDate('end_date', '>=', now())->orderBy('end_date')->take(5)->get(),
        ]);
    }
}
