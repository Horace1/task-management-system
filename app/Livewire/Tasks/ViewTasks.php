<?php

namespace App\Livewire\Tasks;

use App\Models\Task;
use Livewire\Component;
use Livewire\WithPagination;

class ViewTasks extends Component
{

    use WithPagination;

    public $search = '';

    public $sortStartDate = 'asc';

    public $sortEndDate = 'asc';

    public function delete($id)
    {
        Task::find($id)->delete();
    }

    public function render()
    {
        return view('livewire.tasks.view-tasks', [
            'tasks' => Task::latest()
            ->where('name', 'like', "%" . $this->search . "%")
            ->orderBy('start_date', $this->sortStartDate)
            ->orderBy('end_date', $this->sortEndDate)
            ->paginate(10)
        ]);
    }
}
