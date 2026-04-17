<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-1">
            Task Details
        </h2>
        <p class="text-sm text-gray-600">{{ $task->name }}</p>
    </x-slot>

    <div class="py-10">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
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

            <div class="bg-white rounded-xl border border-gray-200 shadow-sm p-6">
                <div class="grid grid-cols-1 gap-6 md:grid-cols-2">
                    <div>
                        <p class="text-xs uppercase tracking-wide text-gray-500">Project</p>
                        <p class="mt-1 text-gray-800">{{ $task->project?->name }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wide text-gray-500">Status</p>
                        <select
                            wire:change="updateTaskStatus({{ $task->id }}, $event.target.value)"
                            class="mt-1 w-full rounded-lg border border-gray-300 py-2 pl-3 pr-10 text-sm text-gray-800"
                        >
                            @foreach($this->taskStatuses as $status)
                                <option value="{{ $status->id }}" @selected($task->task_status_id === $status->id)>
                                    {{ $status->name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wide text-gray-500">Start Date</p>
                        <p class="mt-1 text-gray-800">{{ $task->formatted_start_date }}</p>
                    </div>
                    <div>
                        <p class="text-xs uppercase tracking-wide text-gray-500">End Date</p>
                        <p class="mt-1 text-gray-800">{{ $task->formatted_end_date }}</p>
                    </div>
                </div>

                <div class="mt-6">
                    <p class="text-xs uppercase tracking-wide text-gray-500">Assigned Team Members</p>
                    <p class="mt-2 text-gray-700">
                        {{ $task->users->pluck('full_name')->join(', ') }}
                    </p>
                </div>

                <div class="mt-6">
                    <p class="text-xs uppercase tracking-wide text-gray-500">Description</p>
                    <p class="mt-2 text-gray-700">{{ $task->description }}</p>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('employee.tasks') }}" wire:navigate class="text-sm text-indigo-700 hover:text-indigo-900">
                    Back to Tasks
                </a>
            </div>
        </div>
    </div>
</div>
