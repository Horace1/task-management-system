<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;
use Livewire\WithPagination;

class ViewProjects extends Component
{

    use WithPagination;

    public $search = '';

    public $sortStartDate = 'asc';

    public $sortEndDate = 'asc';

    public function delete($id)
    {
        Project::find($id)->delete();
    }

    public function render()
    {
        return view('livewire.projects.view-projects', [
            'projects' => Project::latest()
                ->where('name', 'like', "%" . $this->search . "%")
                ->orderBy('start_date', $this->sortStartDate)
                ->orderBy('end_date', $this->sortEndDate)
                ->paginate(10)
        ]);
    }
}
