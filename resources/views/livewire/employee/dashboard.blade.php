<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-1">
            {{ getGreeting() }}, {{ Auth::user()->full_name }}
        </h2>
        <p class="text-sm text-gray-600">
            {{ __('Welcome to the Employee Dashboard') }}
        </p>
    </x-slot>

    {{--  Graph data  --}}
    <div class="mt-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
        @if (session()->has('message'))
            <div class="mb-6 rounded-lg bg-green-100 border border-green-300 text-green-800 px-4 py-3 flex items-center gap-2 shadow-sm">
                <i class="fa-solid fa-circle-check text-green-600 mr-2"></i>
                <span class="font-medium">{{ session('message') }}</span>
            </div>
        @endif

        <div class="my-10">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Project Overview</h3>
            <ul role="list" class="grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
                {{-- Chart 1 --}}
                <li class="overflow-hidden rounded-xl border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6 text-4xl justify-center">
                        <i class="fa-solid fa-chart-pie"></i>
                        <div class="text-lg font-medium leading-6 text-gray-900">Project Status Overview</div>
                    </div>
                    <div class="p-4">
{{--                        @if (count($statusCounts) > 0)--}}
{{--                            <canvas id="statusChart1" class="w-full h-64"></canvas>--}}
{{--                        @else--}}
{{--                            <div class="p-6 text-center text-gray-500 flex flex-col items-center justify-center space-y-2">--}}
{{--                                <i class="fa-solid fa-circle-info text-2xl text-gray-400"></i>--}}
{{--                                <span class="italic">No project status data available.</span>--}}
{{--                            </div>--}}
{{--                        @endif--}}
                    </div>
                </li>

                {{-- Chart 2 --}}
                <li class="overflow-hidden rounded-xl border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6 text-4xl justify-center">
                        <i class="fa-solid fa-tasks"></i>
                        <div class="text-lg font-medium leading-6 text-gray-900">Task Per Project</div>
                    </div>
                    <div class="p-4">
{{--                        @if (count($tasksPerProject) > 0)--}}
{{--                            <canvas id="statusChart2" class="w-full h-100"></canvas>--}}
{{--                        @else--}}
{{--                            <div class="p-6 text-center text-gray-500 flex flex-col items-center justify-center space-y-2">--}}
{{--                                <i class="fa-solid fa-circle-info text-2xl text-gray-400"></i>--}}
{{--                                <span class="italic">No task data available for projects.</span>--}}
{{--                            </div>--}}
{{--                        @endif--}}
                    </div>
                </li>

                {{-- Chart 3 --}}
                <li class="overflow-hidden rounded-xl border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6 text-4xl justify-center">
                        <i class="fa-solid fa-user"></i>
                        <div class="text-lg font-medium leading-6 text-gray-900">
                            @can('admin')
                                User Roles
                            @else
                                Employee(s) Per Project
                            @endcan
                        </div>
                    </div>
                    <div class="p-4">
{{--                        @can('admin')--}}
{{--                            @if (count($userRoles) > 0)--}}
{{--                                <canvas id="statusChart3" class="w-full h-64"></canvas>--}}
{{--                            @else--}}
{{--                                <div class="p-6 text-center text-gray-500 flex flex-col items-center justify-center space-y-2">--}}
{{--                                    <i class="fa-solid fa-users-slash text-2xl text-gray-400"></i>--}}
{{--                                    <span class="italic">No user role data available.</span>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @else--}}
{{--                            @if (count($teamMembersPerProject) > 0)--}}
{{--                                <canvas id="statusChart4" class="w-full h-64"></canvas>--}}
{{--                            @else--}}
{{--                                <div class="p-6 text-center text-gray-500 flex flex-col items-center justify-center space-y-2">--}}
{{--                                    <i class="fa-solid fa-users-slash text-2xl text-gray-400"></i>--}}
{{--                                    <span class="italic">No user role data available.</span>--}}
{{--                                </div>--}}
{{--                            @endif--}}
{{--                        @endcan--}}
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="py-12">

        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-5 my-5">
                    <ul role="list" class="grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
                        <!-- Projects Card -->
                        <li class="overflow-hidden rounded-xl border border-gray-200">
                            <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6 text-4xl justify-center">
                                <i class="fa-solid fa-folder-open"></i>
                                <div class="text-lg font-medium leading-6 text-gray-900">My Projects</div>
                            </div>
                            <dl class="my-3 px-6 py-4 text-sm leading-6">
                                <div class="text-center">
                                    <h1 class="text-4xl font-bold">{{ $projects->count() }}</h1>
                                    <p class="text-gray-500">Active Projects</p>
                                </div>
                            </dl>
                        </li>

                        <!-- My Tasks Card -->
                        <li class="overflow-hidden rounded-xl border border-gray-200">
                            <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6 text-4xl justify-center">
                                <i class="fa-solid fa-list-check"></i>
                                <div class="text-lg font-medium leading-6 text-gray-900">My Tasks</div>
                            </div>
                            <dl class="my-3 px-6 py-4 text-sm leading-6">
                                <div class="text-center">
                                    <h1 class="text-4xl font-bold">{{ $tasks->count() }}</h1>
                                    <p class="text-gray-500">Assigned Tasks</p>
                                </div>
                            </dl>
                        </li>

                        <!-- Upcoming Deadlines Card -->
                        <li class="overflow-hidden rounded-xl border border-gray-200">
                            <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6 text-4xl justify-center">
                                <i class="fa-solid fa-calendar-days"></i>
                                <div class="text-lg font-medium leading-6 text-gray-900">Upcoming Deadlines</div>
                            </div>
                            <ul class="px-6 py-4 max-h-64 overflow-y-auto divide-y divide-gray-100 text-sm leading-6">
                                @forelse($upcomingDeadlines as $task)
                                    <li class="py-2">
                                        <div class="flex flex-col">
                                            <span class="font-semibold text-gray-800">{{ $task->title }}</span>
                                            <span class="text-gray-500 text-xs">
                        {{ $task->due_date->format('M d, Y') }} &middot; {{ $task->project->name }}
                    </span>
                                        </div>
                                    </li>
                                @empty
                                    <li class="py-2 text-center text-gray-500">No upcoming deadlines.</li>
                                @endforelse
                            </ul>
                        </li>
                    </ul>
                </div>

                <!-- Table of My Projects -->
                <div class="mx-5 my-5">
                    <h3 class="text-lg font-semibold text-gray-800 mb-3">Projects</h3>
                    <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                        <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead class="bg-gray-50">
                                    <tr>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Project</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Manager</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Progress</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Status</th>
                                        <th class="px-6 py-3 text-left text-sm font-semibold text-gray-900">Actions</th>
                                    </tr>
                                    </thead>
                                    <tbody class="bg-white divide-y divide-gray-200">
                                    @foreach($projects as $project)
                                        <tr>
                                            <td class="px-6 py-4 text-sm text-gray-700">{{ $project->name }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $project->manager->name ?? 'N/A' }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $project->progress }}%</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">{{ $project->status }}</td>
                                            <td class="px-6 py-4 text-sm text-gray-500">
                                                <a href="{{ route('projects.show', $project->id) }}" class="text-blue-600 hover:underline">View</a>
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
