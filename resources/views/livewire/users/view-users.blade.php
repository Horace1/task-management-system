
<div x-data="{ showModal: false }">
    <x-slot name="header">
        <h2 class="text-2xl font-bold text-gray-800">
            {{ getGreeting() }}, {{ Auth::user()->full_name }}
        </h2>
        <p class="text-sm text-gray-500">
            @can('admin')
                Welcome to the Admin Dashboard
            @else
                Welcome to the Project Manager Dashboard
            @endcan
        </p>
    </x-slot>

    <div class="py-10">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">

            @if (session()->has('message'))
                <div x-data="{ show: true }" x-show="show" class="mb-6 rounded-lg bg-green-100 border border-green-300 text-green-800 px-4 py-3 flex items-center justify-between shadow-sm">
                    <div class="flex items-center gap-2">
                        <i class="fa-solid fa-circle-check text-green-600 mr-2"></i>
                        <span class="font-medium">{{ session('message') }}</span>
                    </div>
                    <button @click="show = false" type="button" class="text-green-600 hover:text-green-800 transition-colors">
                        <i class="fa-solid fa-xmark"></i>
                    </button>
                </div>
            @endif

            <!-- Header with Button -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Users</h3>
                    <p class="text-sm text-gray-500">Manage and monitor all system users</p>
                </div>
                <button
                    type="button"
                    wire:click="create"
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r bg-indigo-600 to-purple-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <i class="fa-solid fa-plus mr-2"></i> Create User
                </button>
            </div>

            <!-- Filters -->
            <div class="bg-gray-50 rounded-xl p-4 mb-6 flex flex-wrap gap-4 items-center shadow-sm">
                <!-- Search -->
                <div class="relative flex-1">
                    <input type="search" wire:model.live.debounce.500ms="search"
                           class="w-full pl-3 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm"
                           placeholder="Search users...">
                    <div style="position: absolute; top: 50%; right: 12px; transform: translateY(-50%);">
                        <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                    </div>
                </div>

                <!-- Role Filter Dropdown -->
                <select wire:model.live="roleFilter"
                        class="rounded-lg border border-gray-300 py-2 pl-3 pr-10 text-sm">
                    <option value="">All Roles</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->id }}">{{ $role->title }}</option>
                    @endforeach
                </select>


                <!-- Sort Dropdowns -->
                <select wire:model.live="firstNameDate"
                        class="rounded-lg border border-gray-300 py-2 pl-3 pr-10 text-sm">
                    <option value="asc">First Name (Ascending)</option>
                    <option value="desc">First Name (Descending)</option>
                </select>

                <select wire:model.live="lastNameDate"
                        class="rounded-lg border border-gray-300 py-2 pl-3 pr-10 text-sm">
                    <option value="asc">Last Name (Ascending)</option>
                    <option value="desc">Last Name (Descending)</option>
                </select>
            </div>

            <!-- Table Wrapper -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-300 bg-white shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">#</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">First Name</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Last Name</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Role</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Action</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @foreach($users as $user)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-6">{{ $user->id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $user->first_name }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $user->last_name }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $user->email }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                @foreach($user->roles as $role)
                                    <span class="inline-flex items-center rounded-md
                                        @if($role->name === 'admin')
                                            bg-red-50 text-red-700 ring-red-700/10
                                        @elseif($role->name === 'project-manager')
                                            bg-blue-50 text-blue-700 ring-blue-700/10
                                        @else
                                            bg-green-50 text-green-700 ring-green-700/10
                                        @endif
                                        px-2 py-1 text-xs font-medium ring-1 ring-inset">
                                        {{ $role->title }}
                                    </span>
                                @endforeach
                            </td>

                            <td class="whitespace-nowrap px-3 py-4 text-sm flex gap-4">
                                <button wire:click="view({{ $user->id }})" title="View">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button wire:click="edit({{ $user->id }})" title="Edit">
                                    <i class="fa-solid fa-edit"></i>
                                </button>
                                <button wire:click="delete({{ $user->id }})"
                                        wire:confirm="Are you sure you want to delete this user?"
                                        title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="mt-4">
                {{ $users->links() }}
            </div>
        </div>
    </div>

    <!-- View Modal Overlay -->
    <div x-show="$wire.showModal" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
        <!-- Modal Content -->
        <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-xl mx-auto">
            <!-- Modal Header -->
            <div class="flex justify-between items-center pb-3">
                <h2 class="text-xl font-semibold text-gray-800">
                    @if($mode === 'create')
                        Create User
                    @elseif($mode === 'edit')
                        Edit User
                    @else
                        View User
                    @endif
                </h2>
                <button @click="$wire.showModal = false" class="text-gray-400 hover:text-gray-600 text-xl">
                    &times;
                </button>
            </div>
            <!-- Modal Body -->
            @if($mode === 'view')
                <!-- View Mode -->
                <div class="mt-6 bg-white p-8">
                    <!-- Grid Section -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- User Photo -->
                        <div class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition md:col-span-2 flex justify-center">
                            @if($selectedUser->profile_photo_url)
                                <img class="rounded-full w-24 h-24" src="{{ $selectedUser->profile_photo_url }}" alt="{{ $selectedUser->full_name }}">
                            @else
                                <div class="rounded-full w-24 h-24 bg-gray-200 flex items-center justify-center">
                                    <svg class="h-12 w-12 text-gray-400" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd" />
                                    </svg>
                                </div>
                            @endif
                        </div>

                        <!-- First Name -->
                        <div class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-1 tracking-wide">First Name</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $selectedUser->first_name }}</p>
                        </div>

                        <!-- Last Name -->
                        <div class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-1 tracking-wide">Last Name</p>
                            <p class="text-gray-800 text-lg">{{ $selectedUser->last_name }}</p>
                        </div>

                        <!-- Email -->
                        <div class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-1 tracking-wide">Email</p>
                            <p class="text-gray-800">{{ $selectedUser->email }}</p>
                        </div>

                        <!-- Contact Number -->
                        <div class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-1 tracking-wide">Contact Number</p>
                            <p class="text-gray-800">{{ $selectedUser->contact_number }}</p>
                        </div>

                        <!-- Roles -->
                        <div class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition md:col-span-2">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-1 tracking-wide">Roles</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($selectedUser->roles as $role)
                                    <span class="inline-flex items-center rounded-md
                                        @if($role->name === 'admin')
                                            bg-red-50 text-red-700 ring-red-700/10
                                        @elseif($role->name === 'project-manager')
                                            bg-blue-50 text-blue-700 ring-blue-700/10
                                        @else
                                            bg-green-50 text-green-700 ring-green-700/10
                                        @endif
                                        px-2 py-1 text-xs font-medium ring-1 ring-inset">
                                        {{ $role->title }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                </div>
            @else
                <!-- Create/Edit Form -->
                <div class="space-y-6">
                    <!-- User Photo -->
                    <div class="flex justify-center">
                        <div class="col-span-full">
                            <label for="photo" class="block text-sm font-medium leading-6 text-gray-900">User Photo</label>
                            <div class="mt-2 flex items-center gap-x-3 justify-center">
                                @if($mode === 'edit' && $form['current_profile_photo_path'])
                                    @if(isset($form['profile_photo_path']) && $form['profile_photo_path'] instanceof \Livewire\TemporaryUploadedFile)
                                        <img class="rounded-full w-20 h-20" src="{{ $form['profile_photo_path']->temporaryUrl() }}">
                                    @else
                                        <img class="rounded-full w-20 h-20" src="{{ $form['current_profile_photo_path'] }}">
                                    @endif
                                @elseif(isset($form['profile_photo_path']) && $form['profile_photo_path'] instanceof \Livewire\TemporaryUploadedFile)
                                    <img class="rounded-full w-20 h-20" src="{{ $form['profile_photo_path']->temporaryUrl() }}">
                                @else
                                    <svg class="h-12 w-12 text-gray-300" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M18.685 19.097A9.723 9.723 0 0021.75 12c0-5.385-4.365-9.75-9.75-9.75S2.25 6.615 2.25 12a9.723 9.723 0 003.065 7.097A9.716 9.716 0 0012 21.75a9.716 9.716 0 006.685-2.653zm-12.54-1.285A7.486 7.486 0 0112 15a7.486 7.486 0 015.855 2.812A8.224 8.224 0 0112 20.25a8.224 8.224 0 01-5.855-2.438zM15.75 9a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0z" clip-rule="evenodd" />
                                    </svg>
                                @endif
                                <div wire:loading wire:target="form.profile_photo_path">
                                    <span class="text-green-500">uploading....</span>
                                </div>
                                <input wire:model="form.profile_photo_path" type="file" accept="image/jpeg,image/png,image/gif,image/svg" class="rounded-md bg-white px-2.5 py-1.5 text-sm font-semibold text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 hover:bg-gray-50">
                            </div>
                            @error('form.profile_photo_path') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Name Fields -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">First Name</label>
                            <input type="text" wire:model="form.first_name"
                                   placeholder="Enter first name"
                                   class="w-full rounded-lg border border-gray-300 p-2 text-sm text-gray-700 placeholder-gray-400 placeholder:font-normal focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                            @error('form.first_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Last Name</label>
                            <input type="text" wire:model="form.last_name"
                                   placeholder="Enter last name"
                                   class="w-full rounded-lg border border-gray-300 p-2 text-sm text-gray-700 placeholder-gray-400 placeholder:font-normal focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                            @error('form.last_name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Contact Fields -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Email</label>
                            <input type="email" wire:model="form.email"
                                   placeholder="Enter email"
                                   class="w-full rounded-lg border border-gray-300 p-2 text-sm text-gray-700 placeholder-gray-400 placeholder:font-normal focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                            @error('form.email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Contact Number</label>
                            <input type="text" wire:model="form.contact_number"
                                   placeholder="Enter contact number"
                                   class="w-full rounded-lg border border-gray-300 p-2 text-sm text-gray-700 placeholder-gray-400 placeholder:font-normal focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                            @error('form.contact_number') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    @if($mode === 'create')
                        <!-- Password Fields -->
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Password</label>
                                <input type="password" wire:model="form.password"
                                       placeholder="Enter password"
                                       class="w-full rounded-lg border border-gray-300 p-2 text-sm text-gray-700 placeholder-gray-400 placeholder:font-normal focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                                @error('form.password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 font-medium mb-1">Confirm Password</label>
                                <input type="password" wire:model="form.password_confirmation"
                                       placeholder="Confirm password"
                                       class="w-full rounded-lg border border-gray-300 p-2 text-sm text-gray-700 placeholder-gray-400 placeholder:font-normal focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                                @error('form.password_confirmation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                            </div>
                        </div>
                    @endif

                    <!-- Role -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Role</label>
                        <select wire:model="form.role_id"
                                class="w-full rounded-lg border border-gray-300 p-2 text-sm text-gray-700 focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                            <option value="" disabled selected class="text-gray-400">Select Role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role->id }}">{{ $role->title }}</option>
                            @endforeach
                        </select>
                        @error('form.role_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Footer -->
                    <div class="flex justify-end gap-4 pt-4 border-t">
                        <button type="button" @click="$wire.showModal = false"
                                class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100 transition">
                            Cancel
                        </button>
                        <button wire:click="save"
                                class="inline-flex items-center px-4 py-2 bg-gradient-to-r bg-indigo-600 to-purple-600 text-white text-sm font-semibold rounded-lg shadow hover:from-indigo-500 hover:to-purple-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                            {{ $mode === 'create' ? 'Create' : 'Update' }}
                        </button>
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>
