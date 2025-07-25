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
        $users = User::where(function ($query) {
            $query->where('first_name', 'like', "%" . $this->search . "%")
                ->orWhere('last_name', 'like', "%" . $this->search . "%");
        })
         ->paginate(10);

        return view('livewire.users.view-users', ['users' => $users]);


    }
}
