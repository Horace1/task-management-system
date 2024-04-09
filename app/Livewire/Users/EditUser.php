<?php

namespace App\Livewire\Users;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class EditUser extends Component
{
    public $id;
    public $first_name;
    public $last_name;
    public $email;
    public $role_id;

    public $validationAttributes = [
        'role_id' => 'role',
    ];

    public function rules()
    {
        return [
            'first_name' => 'required|min:3|max:50',
            'last_name' => 'required|min:3|max:50',
            'email' => 'required|email',
            'role_id' => 'required',
        ];
    }

    public function mount($id)
    {
        $this->id = $id;
        $user = User::find($id);
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->role_id = $user->role_id;
    }

    public function update()
    {
        $this->validate();

        User::find($this->id)->update([
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'role_id' => $this->role_id,
        ]);

        $this->redirect('/users');
    }

    public function clearForm()
    {
        $this->reset(['first_name', 'last_name', 'email', 'role_id']);
    }

    public function render()
    {
        return view('livewire.users.edit-user', ['user' => User::find($this->id),'roles' => Role::all()]);
    }
}
