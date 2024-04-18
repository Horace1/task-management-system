<?php

namespace App\Livewire\Users;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\WithFileUploads;
use Livewire\Component;

class EditUser extends Component
{
    use WithFileUploads;

    public $id;
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

    public function mount($id)
    {
        $user = User::find($id);
        $this->id = $id;
        $this->profile_photo_path = $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : null;
        $this->first_name = $user->first_name;
        $this->last_name = $user->last_name;
        $this->email = $user->email;
        $this->contact_number = $user->contact_number;
        $this->role_id = $user->role_id;
    }

    public function update()
    {
        $this->validate();

        if ($this->profile_photo_path) {
            $photoPath = $this->profile_photo_path->store('photos', 'public');
        } else {
            $photoPath = null;
        }

        User::find($this->id)->update([
            'profile_photo_path' => $photoPath,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'contact_number' => $this->contact_number,
            'password' => Hash::make($this->password),
            'role_id' => $this->role_id,
        ]);

        $this->redirect('/users');
    }

    public function clearForm()
    {
        $this->reset(['profile_photo_path','first_name','last_name', 'email','contact_number','role_id']);
    }

    public function render()
    {
        return view('livewire.users.edit-user', ['user' => User::find($this->id),'roles' => Role::all()]);
    }
}
