<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="mx-5 my-5">
                    <ul role="list" class="grid grid-cols-1 gap-x-6 gap-y-8 lg:grid-cols-3 xl:gap-x-8">
                        <li class="overflow-hidden rounded-xl border border-gray-200">
                            <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6 text-4xl justify-center">
                                <i class="fa-solid fa-folder-open"></i>
                                <div class="text-lg font-medium leading-6 text-gray-900">Projects</div>
                            </div>
                            <dl class="my-3 divide-y divide-gray-100 px-6 py-4 text-sm leading-6">
                                <div class="flex items-center justify-center">
                                    <h1 class="text-4xl font-bold">{{ $projects }}</h1>
                                </div>
                            </dl>
                        </li>
                        <li class="overflow-hidden rounded-xl border border-gray-200">
                            <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6 text-4xl justify-center">
                                <i class="fa-solid fa-list-check"></i>
                                <div class="text-lg font-medium leading-6 text-gray-900">Tasks</div>
                            </div>
                            <dl class="my-3 divide-y divide-gray-100 px-6 py-4 text-sm leading-6">
                                <div class="flex items-center justify-center">
                                    <h1 class="text-4xl font-bold">{{ $tasks }}</h1>
                                </div>
                            </dl>
                        </li>
                        <li class="overflow-hidden rounded-xl border border-gray-200">
                            <div class="flex items-center gap-x-4 border-b border-gray-900/5 bg-gray-50 p-6 text-4xl justify-center">
                                <i class="fa-solid fa-users"></i>
                                <div class="text-lg font-medium leading-6 text-gray-900">Users</div>
                            </div>
                            <dl class="my-3 divide-y divide-gray-100 px-6 py-4 text-sm leading-6">
                                <div class="flex items-center justify-center">
                                    <h1 class="text-4xl font-bold">{{ $users }}</h1>
                                </div>
                            </dl>
                        </li>
                    </ul>
                </div>
                <div>
                    <div class="mx-5 my-5">
                        <div class="mt-8 flow-root">
                            <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                                <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                    <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:rounded-lg">
                                        <table class="min-w-full divide-y divide-gray-300">
                                            <thead class="bg-gray-50">
                                            <tr>
                                                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">#</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Project</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Assigned To</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Progress</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Status</th>
                                                <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">View Project</th>
                                            </tr>
                                            </thead>
                                            <tbody class="divide-y divide-gray-200 bg-white">
                                            <tr>
                                                <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">1</td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">Project 1</td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">John Doe</td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">50%</td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">In Progress</td>
                                                <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                                    <a href="#" class="text-gray-900 px-5 text-lg"><i class="fa-solid fa-file"></i></a>
                                                </td>
                                            </tr>
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
    </div>
</div>
