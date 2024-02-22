<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Livewire\Component;

class ViewTask extends Component
{
    public $id;

    public function mount($id)
    {
        $this->id = $id;
    }

    public function render()
    {
        return view('livewire.tasks.view-task',['task' => Task::find($this->id)]);
    }
}
