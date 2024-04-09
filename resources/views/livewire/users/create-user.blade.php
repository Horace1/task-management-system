<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create User') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="px-4 sm:px-6 lg:px-8">
                    <form wire:submit="save">
                        <div class="space-y-12">
                            <div class="border-b border-gray-900/10 pb-12 pt-5">
                                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    <div class="sm:col-span-3">
                                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">First Name</label>
                                        <div class="mt-2">
                                            <input wire:model="first_name" id="first_name" name="first_name" type="text" autocomplete="first name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            @error('first_name')
                                            <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="sm:col-span-3">
                                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Last Name</label>
                                        <div class="mt-2">
                                            <input wire:model="last_name" id="last_name" name="last_name" type="text" autocomplete="last name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            @error('last_name')
                                            <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    <div class="sm:col-span-3">
                                        <label for="email" class="block text-sm font-medium leading-6 text-gray-900">Email</label>
                                        <div class="mt-2">
                                            <input wire:model="email" id="email" name="email" type="text" autocomplete="email" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            @error('email')
                                            <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="sm:col-span-3">
                                        <label for="contact_number" class="block text-sm font-medium leading-6 text-gray-900">Contact Number</label>
                                        <div class="mt-2">
                                            <input wire:model="contact_number" id="contact_number" name="contact_number" type="text" autocomplete="contact number" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            @error('contact_number')
                                            <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-10 grid grid-cols-1 gap-x-6 gap-y-8 sm:grid-cols-6">
                                    <div class="sm:col-span-3">
                                        <label for="role_id" class="block text-sm font-medium leading-6 text-gray-900">Role</label>
                                        <div class="mt-2">
                                            <select wire:model="role_id" name="role_id" id="role_id" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                <option value="#">Please select a project</option>
                                                @foreach($roles as $role)
                                                    <option value="{{ $role->id }}">{{ $role->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('role_id')
                                            <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="sm:col-span-3">
                                        <label for="password" class="block text-sm font-medium leading-6 text-gray-900">Password</label>
                                        <div class="mt-2">
                                            <input wire:model="password" id="password" name="password" type="password" autocomplete="password" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            @error('password')
                                            <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
{{--                                <div class="sm:col-span-4 mt-5">--}}
{{--                                    <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Role</label>--}}
{{--                                    <div class="mt-2">--}}
{{--                                        <select wire:model="role_id" name="role_id" id="role_id" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">--}}
{{--                                            <option value="#">Please select a project</option>--}}
{{--                                            @foreach($roles as $role)--}}
{{--                                                <option value="{{ $role->id }}">{{ $role->name }}</option>--}}
{{--                                            @endforeach--}}
{{--                                        </select>--}}
{{--                                        @error('role_id')--}}
{{--                                        <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>--}}
{{--                                        @enderror--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                            </div>
                        </div>
                        <div class="mt-6 flex items-center justify-end gap-x-6 mb-5">
                            <a href="{{ route('view-users') }}" wire:navigate type="button" class="text-sm font-semibold leading-6 text-gray-900"><i class="fa-solid fa-arrow-left"></i></a>
                            <button wire:click="clearForm" type="button" class="text-sm font-semibold leading-6 text-gray-900">Cancel</button>
                            <button type="submit" class="rounded-md bg-indigo-600 px-3 py-2 text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Save</button>
                            @if(session('success'))
                                <span class="text-green-500 text-xs">Saved</span>
                            @endif
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
