
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
                    <h3 class="text-xl font-semibold text-gray-900">Tasks</h3>
                    <p class="text-sm text-gray-500">Manage and monitor all your tasks</p>
                </div>
                <button
                    type="button"
                    wire:click="create"
                    class="inline-flex items-center px-4 py-2 bg-gradient-to-r bg-indigo-600 to-purple-600 text-white text-sm font-semibold rounded-lg shadow hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">
                    <i class="fa-solid fa-plus mr-2"></i> Create Task
                </button>
            </div>

            <!-- Filters -->
            <div class="bg-gray-50 rounded-xl p-4 mb-6 flex flex-wrap gap-4 items-center shadow-sm">
                <!-- Search -->
                <div class="relative flex-1">
                    <input type="search" wire:model.live.debounce.500ms="search"
                           class="w-full pl-3 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm"
                           placeholder="Search tasks...">
                    <div style="position: absolute; top: 50%; right: 12px; transform: translateY(-50%);">
                        <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                    </div>
                </div>

                <!-- Sort date Dropdowns -->
                <select wire:model.live="sortStartDate"
                        class="rounded-lg border border-gray-300 py-2 pl-3 pr-10 text-sm">
                    <option value="asc">Start Date (Ascending)</option>
                    <option value="desc">Start Date (Descending)</option>
                </select>

                <select wire:model.live="sortEndDate"
                        class="rounded-lg border border-gray-300 py-2 pl-3 pr-10 text-sm">
                    <option value="asc">End Date (Ascending)</option>
                    <option value="desc">End Date (Descending)</option>
                </select>
            </div>

            <!-- Table Wrapper -->
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-300 bg-white shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">#</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Task</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Employee's</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Project</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Start Date</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">End Date</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Description</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Action</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @foreach($tasks as $task)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-6">{{ $task->id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $task->name }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                @foreach($task->users as $user)
                                    {{ $user->full_name }}@if(!$loop->last), @endif
                                @endforeach
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $task->project->name }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $task->taskStatus?->name ?? 'Unknown' }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $task->formatted_start_date }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $task->formatted_end_date }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500 truncate max-w-xs">{{ $task->description }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm flex gap-4">
                                <button wire:click="view({{ $task->id }})" title="View">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button wire:click="edit({{ $task->id }})" title="Edit">
                                    <i class="fa-solid fa-edit"></i>
                                </button>
                                <button wire:click="delete({{ $task->id }})"
                                        wire:confirm="Are you sure you want to delete this task?"
                                        title="Delete">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
            <div class="mt-4">
                {{ $tasks->links() }}
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
                        Create Task
                    @elseif($mode === 'edit')
                        Edit Task
                    @else
                        View Task
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
                        <!-- Task Name -->
                        <div class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-1 tracking-wide">Task Name</p>
                            <p class="text-lg font-semibold text-gray-900">{{ $selectedTask->name }}</p>
                        </div>

                        <!-- Project -->
                        <div class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-1 tracking-wide">Project</p>
                            <p class="text-gray-800 text-lg">{{ $selectedTask->project->name }}</p>
                        </div>

                        <div class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-1 tracking-wide">Status</p>
                            <p class="text-gray-800 text-lg">{{ $selectedTask->taskStatus?->name ?? 'Unknown' }}</p>
                        </div>

                        <!-- Start Date -->
                        <div class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-1 tracking-wide">Start Date</p>
                            <p class="text-gray-800">{{ $selectedTask->formatted_start_date }}</p>
                        </div>

                        <!-- End Date -->
                        <div class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-1 tracking-wide">End Date</p>
                            <p class="text-gray-800">{{ $selectedTask->formatted_end_date }}</p>
                        </div>

                        <!-- Assigned Users -->
                        <div class="p-4 bg-gray-50 rounded-xl hover:bg-gray-100 transition md:col-span-2">
                            <p class="text-xs font-semibold text-gray-500 uppercase mb-1 tracking-wide">Assigned Users</p>
                            <div class="flex flex-wrap gap-2">
                                @foreach($selectedTask->users as $user)
                                    <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-indigo-100 text-indigo-800">
                                        {{ $user->full_name }}
                                    </span>
                                @endforeach
                            </div>
                        </div>
                    </div>

                    <!-- Description Section -->
                    <div class="mt-8">
                        <p class="text-xs font-semibold text-gray-500 uppercase mb-3 tracking-wide">Description</p>
                        <div class="bg-gray-50 rounded-xl p-5 text-gray-700 text-base leading-relaxed shadow-inner">
                            {{ $selectedTask->description }}
                        </div>
                    </div>
                </div>
            @else
                <!-- Create/Edit Form -->
                <div class="space-y-6">
                    <!-- Task Name -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Task Name</label>
                        <input type="text" wire:model="form.name"
                               placeholder="Enter task name"
                               class="w-full rounded-lg border border-gray-300 p-2 text-sm text-gray-700 placeholder-gray-400 placeholder:font-normal focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                        @error('form.name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Project -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Project</label>
                        <select wire:model="form.project_id"
                                class="w-full rounded-lg border border-gray-300 p-2 text-sm text-gray-700 focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                            <option value="" disabled selected class="text-gray-400">Select Project</option>
                            @foreach($projects as $project)
                                <option value="{{ $project->id }}">{{ $project->name }}</option>
                            @endforeach
                        </select>
                        @error('form.project_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Status -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Status</label>
                        <select wire:model="form.task_status_id"
                                class="w-full rounded-lg border border-gray-300 p-2 text-sm text-gray-700 focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                            <option value="" disabled>Select Status</option>
                            @foreach($taskStatuses as $status)
                                <option value="{{ $status->id }}">{{ $status->name }}</option>
                            @endforeach
                        </select>
                        @error('form.task_status_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Assigned Users -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Assign Users</label>
                        <select wire:model="form.users" multiple
                                class="w-full rounded-lg border border-gray-300 p-2 text-sm text-gray-700 focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->full_name }}</option>
                            @endforeach
                        </select>
                        @error('form.users') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Dates -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">Start Date</label>
                            <input type="date" wire:model="form.start_date"
                                   class="w-full rounded-lg border border-gray-300 p-2 text-sm text-gray-700 focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                            @error('form.start_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label class="block text-gray-700 font-medium mb-1">End Date</label>
                            <input type="date" wire:model="form.end_date"
                                   class="w-full rounded-lg border border-gray-300 p-2 text-sm text-gray-700 focus:border-indigo-500 focus:ring focus:ring-indigo-200">
                            @error('form.end_date') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label class="block text-gray-700 font-medium mb-1">Description</label>
                        <textarea wire:model="form.description"
                                  placeholder="Enter description"
                                  class="w-full rounded-lg border border-gray-300 p-2 text-sm text-gray-700 placeholder-gray-400 placeholder:font-normal focus:border-indigo-500 focus:ring focus:ring-indigo-200"
                                  rows="3"></textarea>
                        @error('form.description') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
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
