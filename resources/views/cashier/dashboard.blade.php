<x-app-layout>
    <div class="py-12" x-data="stateCashierDashboard">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <!-- Card -->
                    <div class="mt-2">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8">
                            <div class="scale-100 p-6 bg-white dark:bg-gray-100/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                                @include('cashier.card_list_product')
                            </div>
                            <div class="scale-100 p-6 bg-white dark:bg-gray-100/50 dark:bg-gradient-to-bl from-gray-700/50 via-transparent dark:ring-1 dark:ring-inset dark:ring-white/5 rounded-lg shadow-2xl shadow-gray-500/20 dark:shadow-none flex motion-safe:hover:scale-[1.01] transition-all duration-250 focus:outline focus:outline-2 focus:outline-red-500">
                                @include('cashier.card_list_order')
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @push('scripts')
        <script src=" {{asset('js/stateCashier.js')}} "></script>
    @endpush
</x-app-layout>
