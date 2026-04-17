<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-1">
            {{ getGreeting() }}, {{ Auth::user()->full_name }}
        </h2>
        <p class="text-sm text-gray-600">{{ __('Welcome to the Employee Dashboard') }}</p>
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

            <div class="grid grid-cols-1 gap-6 md:grid-cols-3">
                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">My Projects</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $projectsCount }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">My Tasks</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $tasksCount }}</p>
                </div>
                <div class="rounded-xl border border-gray-200 bg-white p-6 shadow-sm">
                    <p class="text-sm text-gray-500">Upcoming Deadlines</p>
                    <p class="mt-2 text-3xl font-bold text-gray-900">{{ $upcomingDeadlines->count() }}</p>
                </div>
            </div>

            <div class="mt-8 grid grid-cols-1 gap-6 lg:grid-cols-2">
                <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
                    <div class="border-b border-gray-100 px-6 py-4">
                        <h3 class="text-base font-semibold text-gray-900">Upcoming Deadlines</h3>
                    </div>
                    <div class="p-6">
                        @forelse($upcomingDeadlines as $task)
                            <div class="mb-4 last:mb-0">
                                <a href="{{ route('employee.view-task', $task->id) }}" wire:navigate class="font-medium text-indigo-700 hover:text-indigo-900">
                                    {{ $task->name }}
                                </a>
                                <p class="text-sm text-gray-500">
                                    Due {{ \Illuminate\Support\Carbon::parse($task->end_date)->format('d M Y') }} - {{ $task->project?->name }}
                                </p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No upcoming deadlines.</p>
                        @endforelse
                    </div>
                </div>

                <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
                    <div class="border-b border-gray-100 px-6 py-4">
                        <h3 class="text-base font-semibold text-gray-900">Recent Task Activity</h3>
                    </div>
                    <div class="p-6">
                        @forelse($recentTasks as $task)
                            <div class="mb-4 last:mb-0">
                                <a href="{{ route('employee.view-task', $task->id) }}" wire:navigate class="font-medium text-indigo-700 hover:text-indigo-900">
                                    {{ $task->name }}
                                </a>
                                <p class="text-sm text-gray-500">
                                    {{ $task->project?->name }} - {{ $task->taskStatus?->name ?? 'Unknown' }}
                                </p>
                            </div>
                        @empty
                            <p class="text-sm text-gray-500">No tasks found.</p>
                        @endforelse
                    </div>
                </div>
            </div>

            <div class="mt-8 rounded-xl border border-gray-200 bg-white shadow-sm">
                <div class="border-b border-gray-100 px-6 py-4">
                    <h3 class="text-base font-semibold text-gray-900">My Projects</h3>
                </div>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Project</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Manager</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">My Tasks</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                            <th class="px-6 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Action</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                        @forelse($projects as $project)
                            <tr>
                                <td class="px-6 py-4 text-sm text-gray-800">{{ $project->name }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $project->manager?->full_name ?? 'Unassigned' }}</td>
                                <td class="px-6 py-4 text-sm text-gray-500">
                                    @if ($project->tasks->isNotEmpty())
                                        <div class="flex flex-wrap gap-2">
                                            @foreach ($project->tasks as $task)
                                                <span class="inline-flex items-center rounded-md border border-blue-200 bg-blue-50 px-3 py-1 text-xs font-medium text-blue-700">
                                                    {{ $task->name }}
                                                </span>
                                            @endforeach
                                        </div>
                                    @else
                                        <span class="text-gray-400">No tasks assigned</span>
                                    @endif
                                </td>
                                <td class="px-6 py-4 text-sm text-gray-500">{{ $project->status?->name ?? 'Unknown' }}</td>
                                <td class="px-6 py-4 text-sm">
                                    <button
                                        type="button"
                                        wire:click="viewProject({{ $project->id }})"
                                        class="text-gray-900 hover:text-gray-700"
                                        title="View"
                                        aria-label="View project"
                                    >
                                        <i class="fa-solid fa-eye"></i>
                                    </button>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="5" class="px-6 py-8 text-center text-sm text-gray-500">No projects found.</td>
                            </tr>
                        @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <x-dialog-modal wire:model="showProjectModal" maxWidth="4xl">
        <x-slot name="title">
            Project Details
        </x-slot>

        <x-slot name="content">
            @if ($this->selectedProject)
                @include('livewire.employee.projects.partials.project-details-modal-content', [
                    'project' => $this->selectedProject,
                ])
            @endif
        </x-slot>

        <x-slot name="footer">
            <x-secondary-button wire:click="closeProjectModal">
                Close
            </x-secondary-button>
        </x-slot>
    </x-dialog-modal>
</div>
