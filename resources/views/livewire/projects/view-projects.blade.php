<div>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Projects') }}
        </h2>
    </x-slot>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <div class="px-4 sm:px-6 lg:px-8">
                    <div class="sm:flex sm:items-center">
                        <div class="sm:flex-auto mt-5">
                            <h1 class="text-base font-semibold leading-6 text-gray-900">Projects</h1>
                            <p class="mt-2 text-sm text-gray-700">A list of all the projects</p>
                        </div>
                        <div class="mt-4 sm:ml-16 sm:mt-0 sm:flex-none">
                            <a href="{{ route('create-projects') }}" wire:navigate type="button" class="block rounded-md bg-indigo-600 px-3 py-2 text-center text-sm font-semibold text-white shadow-sm hover:bg-indigo-500 focus-visible:outline focus-visible:outline-2 focus-visible:outline-offset-2 focus-visible:outline-indigo-600">Create Project</a>
                        </div>
                    </div>
                    <div class="mt-8 flow-root">
                        <div class="-mx-4 -my-2 overflow-x-auto sm:-mx-6 lg:-mx-8">
                            <div class="inline-block min-w-full py-2 align-middle sm:px-6 lg:px-8">
                                <table class="min-w-full divide-y divide-gray-300">
                                    <thead>
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-0">Project</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Start Date</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">End Date</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Description</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Action</th>
                                    </tr>
                                    </thead>
                                    <tbody class="divide-y divide-gray-200 bg-white">
                                    @foreach($projects as $project)
                                        <tr>
                                            <td class="whitespace-nowrap py-5 pl-4 pr-3 text-sm sm:pl-0">
                                                <div class="font-medium text-gray-900">{{ $project->name }}</div>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                                <div class="text-gray-900">{{ $project->formatted_start_date }}</div>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                                <div class="text-gray-900">{{ $project->formatted_end_date }}</div>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                                <div class="text-gray-900">{{ $project->description }}</div>
                                            </td>
                                            <td class="whitespace-nowrap px-3 py-5 text-sm text-gray-500">
                                                <a href="{{ route('view-project',$project->id) }}" wire:navigate class="text-gray-900 text-lg"><i class="fa-solid fa-file-invoice"></i></a>
                                                <a href="{{ route('edit-project',$project->id) }}" wire:navigate class="text-gray-900 text-lg px-5"><i class="fa-solid fa-pen-to-square"></i></a>
                                                <button type="button" wire:click="delete({{ $project->id }})" wire:confirm="Are you sure you want to delete this post?" class="text-gray-900 text-lg"><i class="fa-solid fa-trash"></i></button>
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
