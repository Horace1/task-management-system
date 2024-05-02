<?php

namespace App\Livewire\Users;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Livewire\Component;

class CreateUser extends Component
{
    use WithFileUploads;

    #[Validate('nullable|image|mimes:jpeg,png,gif,svg|max:2048')]
    public $profile_photo_path;
    #[Validate('required|min:3|max:50')]
    public string $first_name = '';
    #[Validate('required|min:3|max:50')]
    public string $last_name = '';
    #[Validate('required|email')]
    public string $email = '';
    #[Validate('required|min:3|max:11')]
    public string $contact_number = '';
    #[Validate('required|min:3|max:25')]
    public string $password = '';
    #[Validate('required|same:password')]
    public string $password_confirmation = '';
    #[Validate('required', as: 'role')]
    public $role_id;

    public function save()
    {
        $validatedData = $this->validate();

        $validatedData['password'] = Hash::make($validatedData['password']);

        if ($this->profile_photo_path) {
            $validatedData['profile_photo_path'] = $this->profile_photo_path->store('photos','public');
        }

        User::create($validatedData);

        Session::flash('success', 'User saved successfully.');

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
