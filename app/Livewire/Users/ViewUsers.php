<?php

namespace App\Livewire\Users;

use App\Models\User;
use Livewire\Component;
use Livewire\WithPagination;

class ViewUsers extends Component
{
    use WithPagination;

    public $search = '';

    public $firstNameDate = 'asc';

    public $lastNameDate = 'asc';

    public function delete($id)
    {
        User::find($id)->delete();
    }

    public function render()
    {
        return view('livewire.users.view-users', [
            'users' => User::latest()
                ->where(function ($query) {
                    $query->where('first_name', 'like', "%" . $this->search . "%")
                        ->orWhere('last_name', 'like', "%" . $this->search . "%");
                })
                ->orderBy('first_name', $this->firstNameDate)
                ->orderBy('last_name', $this->lastNameDate)
                ->paginate(10)
        ]);


    }
}
