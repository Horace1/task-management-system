<?php

namespace App\Livewire\Users;

use App\Models\Role;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class ViewUsers extends Component
{
    use WithPagination;
    use WithFileUploads;

    public $search = '';
    public $firstNameDate = 'asc';
    public $lastNameDate = 'asc';
    public $roleFilter = '';

    public $showModal = false;
    public $mode = 'create';
    public $selectedUser = null;
    public $roles = [];

    public $form = [
        'id' => null,
        'profile_photo_path' => null,
        'current_profile_photo_path' => null,
        'first_name' => '',
        'last_name' => '',
        'email' => '',
        'contact_number' => '',
        'password' => '',
        'password_confirmation' => '',
        'role_id' => '',
    ];

    public function mount()
    {
        $this->roles = Role::orderBy('title')->get();
    }

    public function create()
    {
        $this->reset('form');
        $this->mode = 'create';
        $this->showModal = true;
    }

    public function edit($userId)
    {
        $user = User::with('roles')->findOrFail($userId);
        $this->form = [
            'id' => $user->id,
            'current_profile_photo_path' => $user->profile_photo_path ? asset('storage/' . $user->profile_photo_path) : null,
            'profile_photo_path' => null,
            'first_name' => $user->first_name,
            'last_name' => $user->last_name,
            'email' => $user->email,
            'contact_number' => $user->contact_number,
            'role_id' => $user->roles->first()->id ?? '',
            'password' => '',
            'password_confirmation' => '',
        ];
        $this->mode = 'edit';
        $this->showModal = true;
    }

    public function view($userId)
    {
        $this->selectedUser = User::with('roles')->findOrFail($userId);
        $this->mode = 'view';
        $this->showModal = true;
    }

    protected function rules()
    {
        $rules = [
            'form.first_name' => 'required|min:3|max:50',
            'form.last_name' => 'required|min:3|max:50',
            'form.email' => 'required|email|unique:users,email' . ($this->mode === 'edit' ? ',' . $this->form['id'] : ''),
            'form.contact_number' => 'required|min:3|max:20',
            'form.role_id' => 'required|exists:roles,id',
            'form.profile_photo_path' => 'nullable|image|mimes:jpeg,png,gif,svg|max:2048',
        ];

        if ($this->mode === 'create') {
            $rules['form.password'] = 'required|min:3|max:25';
            $rules['form.password_confirmation'] = 'required|same:form.password';
        }

        return $rules;
    }

    public function save()
    {
        $this->validate();

        if ($this->mode === 'create') {
            $userData = [
                'first_name' => $this->form['first_name'],
                'last_name' => $this->form['last_name'],
                'email' => $this->form['email'],
                'contact_number' => $this->form['contact_number'],
                'password' => Hash::make($this->form['password']),
            ];

            if ($this->form['profile_photo_path']) {
                $userData['profile_photo_path'] = $this->form['profile_photo_path']->store('photos', 'public');
            }

            $user = User::create($userData);

            $role = Role::findOrFail($this->form['role_id']);
            $user->assign($role->name);

            session()->flash('message', 'User created successfully.');
        } elseif ($this->mode === 'edit') {
            $user = User::with('roles')->findOrFail($this->form['id']);

            $userData = [
                'first_name' => $this->form['first_name'],
                'last_name' => $this->form['last_name'],
                'email' => $this->form['email'],
                'contact_number' => $this->form['contact_number'],
            ];

            if ($this->form['profile_photo_path']) {
                // Delete old photo if exists
                if ($user->profile_photo_path) {
                    Storage::disk('public')->delete($user->profile_photo_path);
                }

                $userData['profile_photo_path'] = $this->form['profile_photo_path']->store('photos', 'public');
            }

            $user->update($userData);

            $currentRole = $user->roles->first();
            $newRole = Role::findOrFail($this->form['role_id']);

            if ($currentRole && $currentRole->id != $this->form['role_id']) {
                $user->retract($currentRole->name);
                $user->assign($newRole->name);
            } elseif (!$currentRole) {
                $user->assign($newRole->name);
            }

            session()->flash('message', 'User updated successfully.');
        }

        $this->showModal = false;
        $this->mode = 'create';
        $this->reset('form', 'selectedUser');
    }

    public function delete($id)
    {
        if (auth()->id() == $id) {
            session()->flash('message', 'You cannot delete your own account from this screen.');
            return;
        }

        $user = User::findOrFail($id);
        $user->delete();

        session()->flash('message', 'User deleted successfully.');
    }

    public function render()
    {
        $users = User::where(function ($query) {
            $query->where('first_name', 'like', "%" . $this->search . "%")
                ->orWhere('last_name', 'like', "%" . $this->search . "%");
        });

        if (!empty($this->roleFilter)) {
            $users = $users->whereHas('roles', function ($query) {
                $query->where('roles.id', $this->roleFilter);
            });
        }

        $users = $users
            ->with('roles')
            ->orderBy('first_name', $this->firstNameDate)
            ->orderBy('last_name', $this->lastNameDate)
            ->paginate(10);

        return view('livewire.users.view-users', ['users' => $users]);
    }
}
