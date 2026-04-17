<div>
    <div class="overflow-hidden rounded-xl border border-gray-200">
        <div class="border-b border-gray-200 bg-gray-50 px-4 py-3">
            <h3 class="text-base font-semibold text-gray-900">Project Details</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full table-fixed divide-y divide-gray-200">
                <colgroup>
                    <col style="width: 10%">
                    <col style="width: 40%">
                    <col style="width: 10%">
                    <col style="width: 40%">
                </colgroup>
                <tbody class="divide-y divide-gray-100">
                <tr>
                    <th scope="row" class="bg-gray-50 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Project</th>
                    <td class="px-4 py-3 text-sm text-gray-800">{{ $project->name }}</td>
                    <th scope="row" class="bg-gray-50 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Manager</th>
                    <td class="px-4 py-3 text-sm text-gray-800">{{ $project->manager?->full_name ?? 'Unassigned' }}</td>
                </tr>
                <tr>
                    <th scope="row" class="bg-gray-50 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                    <td class="px-4 py-3 text-sm text-gray-800">{{ $project->status?->name ?? 'Unknown' }}</td>
                    <th scope="row" class="bg-gray-50 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Assigned Tasks</th>
                    <td class="px-4 py-3 text-sm text-gray-800">{{ $project->tasks->count() }}</td>
                </tr>
                <tr>
                    <th scope="row" class="bg-gray-50 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Start Date</th>
                    <td class="px-4 py-3 text-sm text-gray-800">{{ $project->formatted_start_date }}</td>
                    <th scope="row" class="bg-gray-50 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">End Date</th>
                    <td class="px-4 py-3 text-sm text-gray-800">{{ $project->formatted_end_date }}</td>
                </tr>
                <tr>
                    <th colspan="4" scope="row" class="bg-gray-50 px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Description</th>
                </tr>
                <tr>
                    <td colspan="4" class="px-4 py-3 text-sm text-gray-700">{{ $project->description ?: 'No description provided.' }}</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="mt-6 overflow-hidden rounded-xl border border-gray-200">
        <div class="border-b border-gray-200 bg-gray-50 px-4 py-3">
            <h3 class="text-base font-semibold text-gray-900">My Tasks In This Project</h3>
        </div>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Task</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">Start</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-gray-500">End</th>
                </tr>
                </thead>
                <tbody class="divide-y divide-gray-100">
                @forelse($project->tasks as $task)
                    <tr>
                        <td class="px-4 py-3 text-sm text-gray-800">{{ $task->name }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">
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
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $task->formatted_start_date }}</td>
                        <td class="px-4 py-3 text-sm text-gray-500">{{ $task->formatted_end_date }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="4" class="px-4 py-6 text-center text-sm text-gray-500">No tasks assigned in this project.</td>
                    </tr>
                @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
