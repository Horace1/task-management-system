<?php

namespace App\Livewire\Projects;

use App\Models\Project;
use Livewire\Component;

class ViewProject extends Component
{
    public string $id;

    public function mount($id)
    {
        $this->id = $id;
    }

    public function render()
    {
        return view('livewire.projects.view-project',['project' => Project::find($this->id)]);
    }
}
