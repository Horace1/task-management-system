<?php

namespace App\Livewire\Users;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Livewire\WithFileUploads;
use Livewire\Component;

class CreateUser extends Component
{
    use WithFileUploads;

    public $profile_photo_path;
    public $first_name;
    public $last_name;
    public $email;
    public $contact_number;
    public $password;
    public $password_confirmation;
    public $role_id;

    public $validationAttributes = [
        'role_id' => 'role',
    ];


    public function rules()
    {
        return [
            'profile_photo_path' => 'image',
            'first_name' => 'required|min:3|max:50',
            'last_name' => 'required|min:3|max:50',
            'email' => 'required|email',
            'contact_number' => 'required|min:3|max:11',
            'password' => 'required|min:3|max:25',
            'password_confirmation' => 'required|same:password',
            'role_id' => 'required',
        ];
    }

    public function save()
    {
        $validatedData = $this->validate();

        $validatedData['password'] = Hash::make($validatedData['password']);

        if ($this->profile_photo_path) {
            $validatedData['profile_photo_path'] = $this->profile_photo_path->store('photos','public');
        }

        User::create($validatedData);

        $this->reset();

        return $this->redirect('/users');
    }

    public function clearForm()
    {
        $this->reset(['profile_photo_path','first_name','last_name', 'email','contact_number','role_id']);
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
