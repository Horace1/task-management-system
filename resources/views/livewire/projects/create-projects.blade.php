<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Create project') }}
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
                                        <label for="name" class="block text-sm font-medium leading-6 text-gray-900">Project Name</label>
                                        <div class="mt-2">
                                            <input wire:model="name" type="text" autocomplete="project name" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            @error('name')
                                            <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="sm:col-span-3">
                                        <label for="project_status_id" class="block text-sm font-medium leading-6 text-gray-900">Project Status</label>
                                        <div class="mt-2">
                                            <select wire:model="project_status_id" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                <option value="#">Please select a Status</option>
                                                @foreach($statuses as $status)
                                                    <option value="{{ $status->id }}">{{ $status->name }}</option>
                                                @endforeach
                                            </select>
                                            @error('project_status_id')
                                            <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="sm:col-span-3">
                                        <label for="start-date" class="block text-sm font-medium leading-6 text-gray-900">Start Date</label>
                                        <div class="mt-2">
                                            <input wire:model="start_date" type="date" name="start-date" id="start-date" autocomplete="start-date" min="{{ date('Y-m-d') }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            @error('start_date')
                                            <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="sm:col-span-3">
                                        <label for="end-date" class="block text-sm font-medium leading-6 text-gray-900">End Date</label>
                                        <div class="mt-2">
                                            <input wire:model="end_date" type="date" autocomplete="end-date" min="{{ date('Y-m-d') }}" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                            @error('end_date')
                                            <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="sm:col-span-3">
                                        <label for="start-date" class="block text-sm font-medium leading-6 text-gray-900">Project Manager</label>
                                        <div class="mt-2">
                                            <select wire:model="project_manager" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                <option value="#">Please select a project Manager</option>
                                                @foreach($project_managers as $project_manager)
                                                    <option value="{{ $project_manager->id }}">{{ $project_manager->full_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('Project_manager')
                                            <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="sm:col-span-3">
                                        <label for="employees" class="block text-sm font-medium leading-6 text-gray-900">Employee's</label>
                                        <div class="mt-2">
                                            <select wire:model="employees" multiple id="employees" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6">
                                                <option value="#">Please select your employees</option>
                                                @foreach($project_employees as $employee)
                                                    <option value="{{ $employee->full_name }}">{{ $employee->full_name }}</option>
                                                @endforeach
                                            </select>
                                            @error('employees')
                                            <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="col-span-full">
                                        <label for="description" class="block text-sm font-medium leading-6 text-gray-900">Description</label>
                                        <div class="mt-2">
                                            <textarea wire:model="description" rows="4" name="description" id="description" class="block w-full rounded-md border-0 py-1.5 text-gray-900 shadow-sm ring-1 ring-inset ring-gray-300 placeholder:text-gray-400 focus:ring-2 focus:ring-inset focus:ring-indigo-600 sm:text-sm sm:leading-6"></textarea>
                                            @error('description')
                                                <span class="text-red-500 text-xs mt-3 block">{{ $message }}</span>
                                            @enderror
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="mt-6 flex items-center justify-end gap-x-6 mb-5">
                            <a href="{{ route('view-projects') }}" wire:navigate type="button" class="text-sm font-semibold leading-6 text-gray-900"><i class="fa-solid fa-arrow-left"></i></a>
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
    @script()
        <script>
            $(document).ready(function(){
                $('#employees').select2();

                $('#employees').on('change', function() {
                    let data = $(this).val();
                    $wire.set('employees', data, false);
                });
            })
        </script>
    @endscript
</div>
