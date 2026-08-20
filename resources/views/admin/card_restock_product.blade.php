<div
    x-show="isVisable == 'restock-product'"
    class="fixed flex z-50 justify-center items-center w-full md:inset-0 h-[calc(100%-1rem)] max-h-full">

    <div class="relative p-4 w-full max-w-lg max-h-full">

        <!-- Modal content -->
        <div class="relative bg-gray-400 border border-default rounded-base shadow-sm p-4 md:p-6">

            <!-- Header -->
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-semibold text-heading">
                    Restock Produk
                </h3>

                <button
                    type="button"
                    x-on:click="isVisable = 'card-table'"
                    class="text-gray-500 hover:text-black text-xl">
                    ✕
                </button>
            </div>

            <!-- Form -->
            <form method="POST" @submit.prevent="sendRestockProduct(receivedProduct.stock_id)">

                <div class="grid gap-4 grid-cols-2 py-4 md:py-6">

                    <!-- Nama Produk -->
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block mb-2.5 text-sm font-medium text-heading">
                            Nama Produk
                        </label>

                        <input
                            type="text"
                            x-model="receivedProduct.product_name"
                            readonly
                            class="bg-gray-200 border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 cursor-not-allowed">
                    </div>

                    <!-- Ukuran Produk -->
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block mb-2.5 text-sm font-medium text-heading">
                            Ukuran Produk
                        </label>

                        <input
                            type="text"
                            x-model="receivedProduct.product_size"
                            readonly
                            class="bg-gray-200 border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 cursor-not-allowed">
                    </div>

                    <!-- Harga Produk -->
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block mb-2.5 text-sm font-medium text-heading">
                            Harga Produk
                        </label>

                        <input
                            type="text"
                            x-model="receivedProduct.product_price"
                            readonly
                            class="bg-gray-200 border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 cursor-not-allowed">
                    </div>

                    <!-- Stok Lama -->
                    <div class="col-span-2 sm:col-span-1">
                        <label class="block mb-2.5 text-sm font-medium text-heading">
                            Stok Saat Ini
                        </label>

                        <select x-model="receivedProduct.stock_status">
                            <template x-for="status in listStatus" :key="status.value">
                                <option :value="status.value" x-text="status.label"></option>
                            </template>
                        </select>
                    </div>

                    <!-- Tambah Stok -->
                    <div class="col-span-2">
                        <label class="block mb-2.5 text-sm font-medium text-heading">
                            Tambah Stok
                        </label>

                        <input
                            type="number"
                            x-model="receivedProduct.new_quantity"
                            placeholder="Masukkan jumlah stok baru"
                            class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base block w-full px-3 py-2.5 shadow-xs">
                    </div>

                    <!-- Deskripsi -->
                    <div class="col-span-2">
                        <label class="block mb-2.5 text-sm font-medium text-heading">
                            Keterangan Produk
                        </label>

                        <textarea
                            rows="4"
                            readonly
                            class="bg-gray-200 border border-default-medium text-heading text-sm rounded-base block w-full p-3.5 cursor-not-allowed"
                            x-text="receivedProduct.product_description"></textarea>
                    </div>

                </div>

                <!-- Button -->
                <div class="inline-flex items-center space-x-2 pt-2 md:pt-6">

                    <button
                        type="submit"
                        :disabled="isProcessSubmit"
                        class="inline-flex items-center gap-2 text-white bg-blue-500 hover:bg-blue-700 rounded-lg text-sm px-4 py-2.5">

                        <svg
                            x-show="isProcessSubmit"
                            class="w-5 h-5 animate-spin"
                            viewBox="0 0 24 24"
                            fill="none">

                            <circle
                                class="opacity-25"
                                cx="12"
                                cy="12"
                                r="10"
                                stroke="currentColor"
                                stroke-width="4">
                            </circle>

                            <path
                                class="opacity-75"
                                fill="currentColor"
                                d="M4 12a8 8 0 018-8v4a4 4 0 00-4 4H4z">
                            </path>
                        </svg>

                        <span x-text="isProcessSubmit ? 'Loading...' : 'Simpan'"></span>
                    </button>

                    <button
                        x-on:click="btnCancelRestock(); isVisable = 'card-table'"
                        :disabled="isProcessSubmit"
                        type="button"
                        class="text-body bg-gray-200 hover:bg-gray-400 rounded-lg text-sm px-4 py-2.5">

                        Cancel
                    </button>

                </div>

            </form>
        </div>
    </div>
</div>
