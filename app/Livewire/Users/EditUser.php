<?php

namespace App\Livewire\Users;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use Livewire\Attributes\Validate;
use Livewire\WithFileUploads;
use Livewire\Component;

class EditUser extends Component
{
    use WithFileUploads;

    public $id;
    public $profile_photo_path;
    public $current_profile_photo_path;
    #[Validate('required|min:3|max:50')]
    public string $first_name = '';
    #[Validate('required|min:3|max:50')]
    public string $last_name = '';
    #[Validate('required|email')]
    public string $email = '';
    #[Validate('required|min:3|max:11')]
    public string $contact_number = '';
    #[Validate('required', as: 'role')]
    public string $role_id;

    public function mount($id)
    {
        $user = User::find($id);
        $this->id = $id;
        $this->current_profile_photo_path = $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : null;
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
            $this->validate([
                'profile_photo_path' => 'nullable|image|mimes:jpeg,png,gif,svg|max:2048',
            ]);
        } else {
            $photoPath = $this->current_profile_photo_path;
            $this->validate([
                'profile_photo_path' => 'nullable|image|mimes:jpeg,png,gif,svg|max:2048',
            ]);
        }

        User::find($this->id)->update([
            'profile_photo_path' => $photoPath,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'contact_number' => $this->contact_number,
            'role_id' => $this->role_id,
        ]);

        Session::flash('success', 'User updated successfully.');

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
