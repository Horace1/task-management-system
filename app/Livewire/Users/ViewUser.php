<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;

class ViewUser extends Component
{
    public $id;

    public function mount($id)
    {
        $this->id = $id;
    }

    public function render()
    {
        return view('livewire.users.view-user',['user' => User::find($this->id)]);
    }
}
