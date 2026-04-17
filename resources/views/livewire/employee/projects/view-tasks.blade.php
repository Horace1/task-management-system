<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-1">
            {{ getGreeting() }}, {{ Auth::user()->full_name }}
        </h2>
        <p class="text-sm text-gray-600">{{ __('Your assigned tasks') }}</p>
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

            <div class="bg-gray-50 rounded-xl p-4 mb-6 flex flex-wrap gap-4 items-center shadow-sm">
                <div class="relative flex-1">
                    <input type="search" wire:model.live.debounce.500ms="search"
                           class="w-full pl-3 pr-10 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 text-sm"
                           placeholder="Search tasks or projects...">
                    <div style="position: absolute; top: 50%; right: 12px; transform: translateY(-50%);">
                        <i class="fa-solid fa-magnifying-glass text-gray-400"></i>
                    </div>
                </div>
                <select wire:model.live="sortStartDate" class="rounded-lg border border-gray-300 py-2 pl-3 pr-10 text-sm">
                    <option value="asc">Start Date (Ascending)</option>
                    <option value="desc">Start Date (Descending)</option>
                </select>
                <select wire:model.live="sortEndDate" class="rounded-lg border border-gray-300 py-2 pl-3 pr-10 text-sm">
                    <option value="asc">End Date (Ascending)</option>
                    <option value="desc">End Date (Descending)</option>
                </select>
            </div>

            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-300 bg-white shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">#</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Task</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Project</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Start Date</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">End Date</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @forelse($tasks as $task)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-6">{{ $task->id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $task->name }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $task->project?->name }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
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
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $task->formatted_start_date }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $task->formatted_end_date }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-3 py-6 text-center text-sm text-gray-500">No tasks found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $tasks->links() }}
            </div>
        </div>
    </div>
</div>
