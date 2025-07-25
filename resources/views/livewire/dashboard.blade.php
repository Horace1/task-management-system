<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight mb-1">
            {{ getGreeting() }}, {{ Auth::user()->full_name }}
        </h2>
        <p class="text-sm text-gray-600">
            @can('admin')
                {{ __('Welcome to the Admin Dashboard') }}
            @else
                {{ __('Welcome to the Project Manager Dashboard') }}
            @endcan
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
                        @if (count($statusCounts) > 0)
                            <canvas id="statusChart1" class="w-full h-64"></canvas>
                        @else
                            <div class="p-6 text-center text-gray-500 flex flex-col items-center justify-center space-y-2">
                                <i class="fa-solid fa-circle-info text-2xl text-gray-400"></i>
                                <span class="italic">No project status data available.</span>
                            </div>
                        @endif
                    </div>
                </li>

                {{-- Chart 2 --}}
                <li class="overflow-hidden rounded-xl border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6 text-4xl justify-center">
                        <i class="fa-solid fa-tasks"></i>
                        <div class="text-lg font-medium leading-6 text-gray-900">Task Per Project</div>
                    </div>
                    <div class="p-4">
                        @if (count($tasksPerProject) > 0)
                            <canvas id="statusChart2" class="w-full h-100"></canvas>
                        @else
                            <div class="p-6 text-center text-gray-500 flex flex-col items-center justify-center space-y-2">
                                <i class="fa-solid fa-circle-info text-2xl text-gray-400"></i>
                                <span class="italic">No task data available for projects.</span>
                            </div>
                        @endif
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
                        @can('admin')
                            @if (count($userRoles) > 0)
                                <canvas id="statusChart3" class="w-full h-64"></canvas>
                            @else
                                <div class="p-6 text-center text-gray-500 flex flex-col items-center justify-center space-y-2">
                                    <i class="fa-solid fa-users-slash text-2xl text-gray-400"></i>
                                    <span class="italic">No user role data available.</span>
                                </div>
                            @endif
                        @else
                            @if (count($teamMembersPerProject) > 0)
                                <canvas id="statusChart4" class="w-full h-64"></canvas>
                            @else
                                <div class="p-6 text-center text-gray-500 flex flex-col items-center justify-center space-y-2">
                                    <i class="fa-solid fa-users-slash text-2xl text-gray-400"></i>
                                    <span class="italic">No user role data available.</span>
                                </div>
                            @endif
                        @endcan
                    </div>
                </li>
            </ul>
        </div>
    </div>

    {{-- Quick Stats --}}
    <div class="mt-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
        <h3 class="text-lg font-semibold text-gray-700 mb-4">Quick Stats</h3>
        <ul role="list" class="grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
            <a href="">
                <li class="overflow-hidden rounded-xl border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6 text-4xl justify-center">
                        <i class="fa-solid fa-folder-open"></i>
                        <div class="text-lg font-medium leading-6 text-gray-900">Projects</div>
                    </div>
                    <div class="flex items-center justify-center py-6">
                        <h1 class="text-4xl font-bold">{{ $projects }}</h1>
                    </div>
                </li>
            </a>
            <a href="">
                <li class="overflow-hidden rounded-xl border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6 text-4xl justify-center">
                        <i class="fa-solid fa-list-check"></i>
                        <div class="text-lg font-medium leading-6 text-gray-900">Tasks</div>
                    </div>
                    <div class="flex items-center justify-center py-6">
                        <h1 class="text-4xl font-bold">{{ $tasks }}</h1>
                    </div>
                </li>
            </a>
            <a href="">
                <li class="overflow-hidden rounded-xl border border-gray-200 hover:shadow-md transition">
                    <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6 text-4xl justify-center">
                        <i class="fa-solid fa-users"></i>
                        <div class="text-lg font-medium leading-6 text-gray-900">
                            @can('admin')
                                Total Users
                            @else
                                Total Employee(s)
                            @endcan
                        </div>
                    </div>
                    <div class="flex items-center justify-center py-6">
                        <h1 class="text-4xl font-bold">{{ $users }}</h1>
                    </div>
                </li>
            </a>
        </ul>
    </div>

    <div x-data="{ viewProject: false, viewRecentProject: {},editProject: false, editProjectId: @entangle('editProjectId').live}">

    {{-- Recent Projects Table --}}
        <div class="mt-10 max-w-7xl mx-auto sm:px-6 lg:px-8">
            <h3 class="text-lg font-semibold text-gray-700 mb-4">Recent Projects</h3>
            <div class="overflow-x-auto mt-6 pb-10">
                <table class="min-w-full divide-y divide-gray-300 bg-white shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                    <thead class="bg-gray-50">
                    <tr>
                        <th class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">#</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Project</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">
                            @can('admin')
                                Project Manager Assigned
                            @else
                                Employee(s) Assigned to Project
                            @endcan
                        </th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Progress</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                        <th class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">View</th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200">
                    @forelse($recentProjects as $index => $project)
                        <tr wire:key="project-{{ $project->id }}">
                            <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm text-gray-900 sm:pl-6">{{ $index + 1 }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-700">{{ $project->name }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                @if(auth()->user()->isAn('admin'))
                                    {{ $project->manager?->full_name ?? 'Unassigned' }}
                                @elseif(auth()->user()->isA('project-manager'))
                                    @php
                                        $employeeNames = $project->tasks
                                        ->flatMap->users
                                        ->pluck('full_name')
                                        ->unique();
                                    @endphp

                                    @if ($employeeNames->isEmpty())
                                        <em>No employees</em>
                                    @else
                                        {{ $employeeNames->join(', ') }}
                                    @endif
                                @endif
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                <div class="w-40 bg-gray-200 rounded-full h-2.5">
                                    <div class="bg-green-500 h-2.5 rounded-full" style="width: {{ $project->progress }}%"></div>
                                </div>
                                <span class="text-xs text-gray-600">{{ $project->progress }}%</span>
                            </td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">{{ $project->status?->name ?? 'Unknown' }}</td>
                            <td class="whitespace-nowrap px-3 py-4 text-sm flex gap-4">
                                <button
                                    type="button"
                                    @click="viewProject = true; viewRecentProject = @js($project)"
                                    title="View">
                                    <i class="fa-solid fa-eye"></i>
                                </button>
                                <button wire:click="confirmDelete({{ $project->id }})"
                                        title="Delete"
                                        onclick="return confirm('Are you sure you want to delete this project?');">
                                    <i class="fa-solid fa-trash"></i>
                                </button>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center py-4 text-gray-500">No projects found.</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <!-- View Modal Overlay -->
        <div x-show="viewProject" class="fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center z-50">
            <!-- Modal Content -->
            <div class="bg-white rounded-xl shadow-xl p-6 w-full max-w-xl mx-auto">
                <!-- Modal Header -->
                <div class="flex justify-between items-center pb-3">
                    <h2 class="text-xl font-semibold text-gray-800">Viewing Project</h2>
                    <button @click="viewProject = false" class="text-gray-400 hover:text-gray-600 text-xl">
                        &times;
                    </button>
                </div>

                {{--            <!-- Modal Body -->--}}
                <div class="mt-6 divide-y divide-gray-200 border rounded-lg text-gray-700">
                    <div class="px-4 py-3 flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-500">Name:</span>
                        <span class="text-base font-semibold" x-text="viewRecentProject.name"></span>
                    </div>

                    <div class="px-4 py-3 flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-500">Start Date:</span>
                        <span class="text-base" x-text="viewRecentProject.start_date"></span>
                    </div>

                    <div class="px-4 py-3 flex justify-between items-center">
                        <span class="text-sm font-medium text-gray-500">End Date:</span>
                        <span class="text-base" x-text="viewRecentProject.end_date"></span>
                    </div>

                    <div class="px-4 py-3">
                        <span class="text-sm font-medium text-gray-500 block mb-1">Description</span>
                        <p class="text-base leading-relaxed" x-text="viewRecentProject.description"></p>
                    </div>
                </div>

                <!-- Modal Footer -->
                <div class="mt-6 text-right">
                    <button
                        @click="showModal = false"
                        class="px-4 py-2 bg-gray-700 text-white rounded hover:bg-gray-800"
                    >
                        Close
                    </button>
                </div>
            </div>
        </div>
    </div>

</div>

@script
<script>
    const initDashboardCharts = () => {
        // Helper function to safely create or update a chart
        const createOrUpdateChart = (canvasId, config) => {
            const canvas = document.getElementById(canvasId);
            if (!canvas) return;

            // Set the chart's container height to 400px, as you requested
            if (canvas.parentElement) {
                canvas.parentElement.style.height = '400px';
            }

            // If a chart instance already exists, destroy it before creating a new one
            let existingChart = Chart.getChart(canvas);
            if (existingChart) {
                existingChart.destroy();
            }

            // Create the new chart
            new Chart(canvas, config);
        };

        // Chart 1: Project Statuses
        createOrUpdateChart('statusChart1', {
            type: 'pie',
            data: {
                labels: @json(array_keys($statusCounts)),
                datasets: [{
                    label: 'Project Statuses',
                    data: @json(array_values($statusCounts)),
                    backgroundColor: ['#4ade80', '#facc15', '#f87171'],
                    borderWidth: 1
                }]
            }
        });

        // Chart 2: Tasks per Project
        createOrUpdateChart('statusChart2', {
            type: 'bar',
            data: {
                labels: @json(array_keys($tasksPerProject)),
                datasets: [{
                    label: 'Tasks per Project',
                    data: @json(array_values($tasksPerProject)),
                    backgroundColor: ['#4ade80', '#60a5fa', '#facc15', '#f87171', '#c084fc'],
                    borderRadius: 4,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 }, title: { display: true, text: 'Task Count' }},
                    x: { title: { display: true, text: 'Projects' }}
                }
            }
        });

        // Chart 3: User Roles
        createOrUpdateChart('statusChart3', {
            type: 'bar',
            data: {
                labels: @json(array_keys($userRoles ?? [])),
                datasets: [{
                    label: 'User Roles',
                    data: @json(array_values($userRoles ?? [])),
                    backgroundColor: ['#6366f1', '#f43f5e', '#22d3ee'],
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 }, title: { display: true, text: 'User Count' }},
                    x: { title: { display: true, text: 'Roles' }}
                }
            }
        });

        // Chart 4: Team Members per Project
        createOrUpdateChart('statusChart4', {
            type: 'bar',
            data: {
                labels: @json(array_keys($teamMembersPerProject)),
                datasets: [{
                    label: 'Employee(s) per Project',
                    data: @json(array_values($teamMembersPerProject)),
                    backgroundColor: ['#22c55e', '#3b82f6', '#f97316', '#e11d48', '#a855f7'],
                    borderRadius: 4,
                    borderWidth: 1
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: { legend: { display: false } },
                scales: {
                    y: { beginAtZero: true, ticks: { stepSize: 1, precision: 0 }, title: { display: true, text: 'Employee(s) Per Project' }},
                    x: { title: { display: true, text: 'Projects' }}
                }
            }
        });

        // Initialize Select2
        const selectElement = $('#employees');
        if (selectElement.length) {
            if (selectElement.hasClass('select2-hidden-accessible')) {
                selectElement.select2('destroy');
            }
            selectElement.select2();
            selectElement.off('change').on('change', function () {
            @this.set('employees', $(this).val());
            });
        }
    };

    // Run the initialization script
    initDashboardCharts();
</script>
@endscript
