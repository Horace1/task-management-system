<?php

namespace App\Livewire\Users;

use App\Models\Role;
use App\Models\User;
use Livewire\Component;

class CreateUser extends Component
{
    public $first_name;
    public $last_name;
    public $email;
    public $contact_number;
    public $password;
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
            'contact_number' => 'required|min:3|max:11',
            'password' => 'required|min:3|max:25',
            'role_id' => 'required',
        ];
    }

    public function save()
    {
        $validated = $this->validate();

        User::create($validated);
        $this->reset();

        return $this->redirect('/users');
    }

    public function clearForm()
    {
        $this->reset(['first_name','last_name', 'email','contact_number','role_id']);
    }

    public function render()
    {
        $roles = Role::all();

        if (auth()->user()->role->name !== 'Admin') {
            $roles = $roles->reject(function ($role) {
                return $role->name === 'Admin';
            });
        }

        return view('livewire.users.create-user',['roles' => $roles]);
    }
}
