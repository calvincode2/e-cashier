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
                    <div class="mb-3">
                        <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                            stroke="currentColor" class="size-6">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.993 0 3.181 3.183a8.25 8.25 0 0 0 13.803-3.7M4.031 9.865a8.25 8.25 0 0 1 13.803-3.7l3.181 3.182m0-4.991v4.99" />
                        </svg>
                    </div>
                    @foreach ($orders as $order)
                        <div x-data="{ open: false }" class="border border-gray-300 rounded-lg mb-3">

                            {{-- HEADER ORDER --}}
                            <button type="button" @click="open = !open"
                                class="w-full flex items-center justify-between p-4 hover:bg-gray-50">

                                <div class="text-left">
                                    <p class="font-semibold">
                                        Order #{{ $order->kode_invoice }}
                                    </p>

                                    <p class="text-sm text-gray-500">
                                        {{ $order->created_at?->format('d M Y H:i') ?? '-' }}
                                    </p>
                                </div>

                                {{-- ARROW --}}
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                    stroke-width="1.5" stroke="currentColor"
                                    class="w-5 h-5 transition-transform duration-200" :class="{ 'rotate-180': open }">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="m19.5 8.25-7.5 7.5-7.5-7.5" />
                                </svg>

                            </button>


                            {{-- DETAIL --}}
                            <div x-show="open" x-collapse class="border-t border-gray-300 p-5">

                                <h4 class="font-semibold underline mb-5">
                                    INFORMASI DETAIL ORDER #{{ $order->kode_invoice }}
                                </h4>

                                {{-- PRODUK --}}
                                <div class="space-y-3">

                                    @foreach ($order->orderDetail as $detail)
                                        <div class="flex justify-between">

                                            <div>
                                                <span class="font-medium">
                                                    Product ID:
                                                </span>

                                                {{ $detail->product_id }}

                                                <span class="text-gray-500">
                                                    ({{ $detail->quantity }}x)
                                                </span>
                                            </div>

                                            <div>
                                                Rp.
                                                {{ number_format($detail->price, 0, ',', '.') }}
                                            </div>

                                        </div>
                                    @endforeach

                                </div>

                                <hr class="my-4">

                                {{-- INFORMASI ORDER --}}
                                <div class="space-y-3">

                                    <div class="flex justify-between">
                                        <span class="font-medium">
                                            Total Pembayaran
                                        </span>

                                        <span>
                                            Rp.
                                            {{ number_format($order->price, 0, ',', '.') }}
                                        </span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span class="font-medium">
                                            Jumlah Barang
                                        </span>

                                        <span>
                                            {{ $order->quantity }}
                                        </span>
                                    </div>

                                    <div class="flex justify-between">
                                        <span class="font-medium">
                                            Tipe Order
                                        </span>

                                        <span class="text-green-600">
                                            {{ $order->type }}
                                        </span>
                                    </div>

                                </div>

                            </div>

                        </div>
                    @endforeach

                    </ul>
                </div>
            </div>

        </div>
    </div>
    </div>
    </div>
</x-app-layout>
