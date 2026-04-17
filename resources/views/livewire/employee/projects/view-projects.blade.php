<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-1">
            {{ getGreeting() }}, {{ Auth::user()->full_name }}
        </h2>
        <p class="text-sm text-gray-600">{{ __('Your assigned projects') }}</p>
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
                           placeholder="Search projects...">
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
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Project</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Manager</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">My Tasks</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Start Date</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">End Date</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Action</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @forelse($projects as $project)
                        <tr>
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-6">{{ $project->id }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $project->name }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $project->manager?->full_name ?? 'Unassigned' }}</td>
                            <td class="px-3 py-4 text-sm text-gray-500">
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
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $project->status?->name ?? 'Unknown' }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $project->formatted_start_date }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $project->formatted_end_date }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm">
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
                            <td colspan="8" class="px-3 py-6 text-center text-sm text-gray-500">No projects found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>

            <div class="mt-4">
                {{ $projects->links() }}
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
