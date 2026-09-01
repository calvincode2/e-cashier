<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('History') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div
                        class="w-full p-6 bg-neutral-primary-soft border border-default rounded-base shadow-xs">
                        <div class="flex items-center justify-between mb-4">
                            <h5 class="text-xl font-semibold leading-none text-heading">Latest Customers</h5>
                            <a href="#" class="font-medium text-fg-brand hover:underline">View all</a>
                        </div>
                        <div class="flow-root">
                            <ul role="list" class="divide-y divide-default">
                                <li class="py-4 sm:py-4">
                                    <div class="flex items-center gap-2">
                                        <div class="shrink-0">
                                            <img class="w-8 h-8 rounded-full"
                                                src="/docs/images/people/profile-picture-1.jpg" alt="Neil image">
                                        </div>
                                        <div class="flex-1 min-w-0 ms-2">
                                            <p class="font-medium text-heading truncate">
                                                Neil Sims
                                            </p>
                                            <p class="text-sm text-body truncate">
                                                email@windster.com
                                            </p>
                                        </div>
                                        <div class="inline-flex items-center font-medium text-heading">
                                            $320
                                        </div>
                                    </div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
