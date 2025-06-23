<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-5">
            @can('admin')
                <span>{{ __('Admin Users') }}</span>
            @else
                <span>{{ __('Project Manager Users') }}</span>
            @endcan
        </h2>
        <h2>Welcome {{ Auth::user()->full_name }}</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto mt-5">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">Users</h1>
                            <p class="mt-2 text-sm text-gray-700">A list of all the Users</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a href="{{ route('create-user') }}" wire:navigate type="button" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Create User</a>
                        </div>
                    </div>
                    <div class="mt-8 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <div class="flex mb-5">
                                    <!-- First element -->
                                    <label for="search-field" class="sr-only">Search</label>
                                    <div class="relative w-full border-b">
                                        <svg class="pointer-events-none absolute inset-y-0 left-0 h-full w-5 text-gray-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                            <path fill-rule="evenodd" d="M9 3.5a5.5 5.5 0 100 11 5.5 5.5 0 000-11zM2 9a7 7 0 1112.452 4.391l3.328 3.329a.75.75 0 11-1.06 1.06l-3.329-3.328A7 7 0 012 9z" clip-rule="evenodd" />
                                        </svg>
                                        <input wire:model.live.debounce.500ms="search" id="search-field" class="block h-full w-full border-0 bg-transparent py-0 pl-8 pr-0 text-gray-900 focus:ring-0 sm:text-sm" placeholder="Search..." type="search" name="search">
                                    </div>
                                    <!-- Second element -->
                                    <select wire:model.live="firstNameDate" name="sort_start_date" id="sort_start_date" class="ml-5 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <option value="asc">First Name Ascending</option>
                                        <option value="desc">First Name Descending</option>
                                    </select>

                                    <select wire:model.live="lastNameDate" name="sort_end_date" id="sort_end_date" class="ml-5 block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                        <option value="asc">Last Name Ascending</option>
                                        <option value="desc">Last Name Descending</option>
                                    </select>
                                </div>
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">#</th>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">User Profile</th>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Name</th>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Email</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Contact Number</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Role</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach($users as $user)
                                        <tr>
                                            <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                                                <div class="font-medium text-gray-900">{{ $user->id }}</div>
                                            </td>
                                            <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                                                <div class="flex items-center">
                                                    <div class="h-20 w-20 flex-shrink-0">
                                                        @if($user->profile_photo_path)
                                                            <img class="h-20 w-20 rounded-full" src="{{ asset('storage/'.$user->profile_photo_path) }}" alt="">
                                                        @endif
                                                    </div>
                                                </div>
                                            </td>
                                            <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                                                <div class="font-medium text-gray-900">{{ $user->full_name }}</div>
                                            </td>
                                            <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                                                <div class="font-medium text-gray-900">{{ $user->email }}</div>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                                <div class="text-gray-900">{{ $user->contact_number }}</div>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                                <div class="text-gray-900">{{ $user->role->title }}</div>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                                <a href="{{ route('view-user',$user->id) }}" wire:navigate class="text-gray-900 text-lg"><i class="fa-solid fa-file-invoice"></i></a>
                                                <a href="{{ route('edit-user',$user->id) }}" wire:navigate class="text-gray-900 text-lg px-5"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <button type="button" wire:click="delete({{ $user->id }})" wire:confirm="Are you sure you want to delete this user?" class="text-gray-900 text-lg"><i class="fa-solid fa-trash"></i></button>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
