<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-1">
            Project Details
        </h2>
        <p class="text-sm text-gray-600">{{ $project->name }}</p>
    </x-slot>

    <div class="py-10">
        <div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8">
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

            <div class="overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                    <h3 class="text-base font-semibold text-gray-900">Project Details</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full table-fixed divide-y divide-gray-200">
                        <colgroup>
                            <col style="width: 15%">
                            <col style="width: 35%">
                            <col style="width: 15%">
                            <col style="width: 35%">
                        </colgroup>
                        <tbody class="divide-y divide-gray-100">
                        <tr>
                            <th scope="row" class="bg-gray-50 px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Project</th>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $project->name }}</td>
                            <th scope="row" class="bg-gray-50 px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Manager</th>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $project->manager?->full_name ?? 'Unassigned' }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-gray-50 px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $project->status?->name ?? 'Unknown' }}</td>
                            <th scope="row" class="bg-gray-50 px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Assigned Tasks</th>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $project->tasks->count() }}</td>
                        </tr>
                        <tr>
                            <th scope="row" class="bg-gray-50 px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Start Date</th>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $project->formatted_start_date }}</td>
                            <th scope="row" class="bg-gray-50 px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">End Date</th>
                            <td class="px-6 py-4 text-sm text-gray-800">{{ $project->formatted_end_date }}</td>
                        </tr>
                        <tr>
                            <th colspan="4" scope="row" class="bg-gray-50 px-6 py-4 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Description</th>
                        </tr>
                        <tr>
                            <td colspan="4" class="px-6 py-4 text-sm text-gray-700">{{ $project->description ?: 'No description provided.' }}</td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-8 overflow-hidden rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-200 bg-gray-50 px-6 py-4">
                    <h3 class="text-base font-semibold text-gray-900">My Tasks In This Project</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Task</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Start</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">End</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        @forelse($project->tasks as $task)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $task->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    <select
                                        wire:change="updateTaskStatus({{ $task->id }}, $event.target.value)"
                                        class="rounded-lg border border-gray-300 py-2 pl-3 pr-10 text-sm"
                                    >
                                        @foreach($this->taskStatuses as $status)
                                            <option value="{{ $status->id }}" @selected($task->task_status_id === $status->id)>
                                                {{ $status->name }}
                                            </option>
                                        @endforeach
                                    </select>
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $task->formatted_start_date }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $task->formatted_end_date }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="4" class="px-6 py-8 text-center text-sm text-gray-500">No tasks assigned in this project.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            <div class="mt-6">
                <a href="{{ route('employee.projects') }}" wire:navigate class="text-sm text-indigo-700 hover:text-indigo-900">
                    Back to Projects
                </a>
            </div>
        </div>
    </div>
</div>
