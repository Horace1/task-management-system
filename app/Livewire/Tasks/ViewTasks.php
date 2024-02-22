<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Livewire\Component;

class ViewTasks extends Component
{
    public function delete($id)
    {
        Task::find($id)->delete();
    }

    public function render()
    {
        return view('livewire.tasks.view-tasks', ['tasks' => Task::all()]);
    }
}
