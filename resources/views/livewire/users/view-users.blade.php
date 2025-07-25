
<div>
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
            <!-- Header with Button -->
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h3 class="text-xl font-semibold text-gray-900">Users</h3>
                    <p class="text-sm text-gray-500">Manage and monitor all system users</p>
                </div>
                <a href="{{ route('register') }}" wire:navigate
                   class="inline-flex items-center px-4 py-2 bg-gradient-to-r bg-indigo-600 to-purple-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <i class="fa-solid fa-plus mr-2"></i> Create User
                </a>
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



                <!-- Sort Dropdowns -->
                <select wire:model.live="firstNameDate"
                        class="rounded-lg border border-gray-300 py-2 px-3 text-sm">
                    <option value="asc">First Name ↑</option>
                    <option value="desc">First Name ↓</option>
                </select>

                <select wire:model.live="lastNameDate"
                        class="rounded-lg border border-gray-300 py-2 px-3 text-sm">
                    <option value="asc">Last Name ↑</option>
                    <option value="desc">Last Name ↓</option>
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
                                <a href="{{ route('profile.show') }}" wire:navigate title="View">
                                    <i class="fa-solid fa-eye"></i>
                                </a>
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
</div>
