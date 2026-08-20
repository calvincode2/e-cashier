<x-app-layout>
    <div class="py-12" x-data="stateListProduct()" x-cloak>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    {{-- start alert dialog --}}
                    {{-- end alert dialog --}}

                    {{-- start komponent toggle form create product --}}
                    <button
                        x-on:click="btnCreateProduct"
                        x-show="isVisable == 'card-table'"
                        class="text-white bg-blue-600 mb-4 rounded-lg box-border border border-transparent hover:bg-brand-strong focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none"
                        type="button">
                        Tambah Produk
                    </button>

                    <!-- Main modal -->
                    <div
                        x-show="isVisable == 'create-product'"
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50 p-4">
                        <div class="relative w-full max-w-lg">
                            <!-- Modal content -->
                            <div class="relative bg-gray-400 border border-default rounded-base shadow-sm p-4 md:p-6">

                                <!-- Modal body -->
                                <form @submit.prevent="sendDataProduct">
                                    <div class="grid gap-4 grid-cols-2 py-4 md:py-6">
                                        <div class="col-span-2 sm:col-span-1">
                                            <label
                                                for="name"
                                                class="block mb-2.5 text-sm font-medium text-heading">
                                                Nama Produk
                                            </label>
                                            <input
                                                type="text"
                                                x-model="product.name"
                                                id="name"
                                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                                                placeholder="Type product name">
                                            {{-- menampilkan pesan error nama produk --}}
                                            <template x-if="errors.name">
                                                <p x-text="errors.name" class="mt-2.5 text-sm text-red-400"></p>
                                            </template>

                                        </div>
                                        <div class="col-span-2 sm:col-span-1">
                                            <label
                                                for="price"
                                                class="block mb-2.5 text-sm font-medium text-heading">
                                                Jumlah Produk
                                            </label>
                                            <select x-model="product.quantity" id="product.quantity" class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand px-3 py-2.5 shadow-xs placeholder:text-body">
                                                <option selected="">Pilih Jumlah</option>
                                                <template x-for="index in 10" :key="index">
                                                    <option :value="index" x-text="index"></option>
                                                </template>
                                            </select>
                                            <template x-if="errors.quantity">
                                                <p x-text="errors.quantity" class="mt-2.5 text-sm text-red-400"></p>
                                            </template>
                                        </div>
                                        <div class="col-span-2 sm:col-span-1">
                                            <label
                                                for="category"
                                                class="block mb-2.5 text-sm font-medium text-heading">
                                                Harga Produk
                                            </label>
                                            <input
                                                type="number"
                                                x-model="product.price"
                                                id="product.price"
                                                class="bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full px-3 py-2.5 shadow-xs placeholder:text-body"
                                                placeholder="Rp.10000">
                                            <template x-if="errors.price">
                                                <p x-text="errors.price" class="mt-2.5 text-sm text-red-400"></p>
                                            </template>
                                        </div>
                                        <div class="col-span-2 sm:col-span-1">
                                            <label
                                                for="product.size"
                                                class="block mb-2.5 text-sm font-medium text-heading">
                                                Ukuran Produk
                                            </label>
                                            <select
                                                x-model="product.size"
                                                id="product.size"
                                                class="block w-full px-3 py-2.5 bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand px-3 py-2.5 shadow-xs placeholder:text-body">
                                                <option selected="">Pilih Ukuran</option>
                                                <template x-for="size in listSize" :key="size">
                                                    <option :value="size" x-text="size"></option>
                                                </template>
                                            </select>
                                            <template x-if="errors.size">
                                                <p x-text="errors.size" class="mt-2.5 text-sm text-red-400"></p>
                                            </template>
                                        </div>
                                        <div class="col-span-2">
                                            <label
                                                for="description"
                                                class="block mb-2.5 text-sm font-medium text-heading">
                                                Keterangan Produk
                                            </label>
                                            <textarea
                                                x-model="product.description"
                                                id="product.description"
                                                rows="4"
                                                class="block bg-neutral-secondary-medium border border-default-medium text-heading text-sm rounded-base focus:ring-brand focus:border-brand block w-full p-3.5 shadow-xs placeholder:text-body" placeholder="Write product description here"></textarea>
                                        </div>
                                        <template x-if="errors.description">
                                            <p x-text="errors.description" class="mt-2.5 text-sm text-red-400"></p>
                                        </template>
                                    </div>
                                    <div class="inline-flex items-center space-x-2 pt-2 md:pt-6">
                                        <button
                                            type="submit"
                                            x-bind:disabled="isProcessSubmit == true"
                                            class="inline-flex items-center  text-white bg-blue-400 hover:bg-blue-600 rounded-lg box-border border border-transparent focus:ring-4 focus:ring-brand-medium shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                                            <svg x-show="isProcessSubmit == false" class="w-4 h-4 me-1.5 -ms-0.5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14m-7 7V5" />
                                            </svg>
                                            <svg x-show="isProcessSubmit == true" aria-hidden="true" role="status" class="w-4 h-4 me-2 text-white animate-spin" viewBox="0 0 100 101" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M100 50.5908C100 78.2051 77.6142 100.591 50 100.591C22.3858 100.591 0 78.2051 0 50.5908C0 22.9766 22.3858 0.59082 50 0.59082C77.6142 0.59082 100 22.9766 100 50.5908ZM9.08144 50.5908C9.08144 73.1895 27.4013 91.5094 50 91.5094C72.5987 91.5094 90.9186 73.1895 90.9186 50.5908C90.9186 27.9921 72.5987 9.67226 50 9.67226C27.4013 9.67226 9.08144 27.9921 9.08144 50.5908Z" fill="#E5E7EB" />
                                                <path d="M93.9676 39.0409C96.393 38.4038 97.8624 35.9116 97.0079 33.5539C95.2932 28.8227 92.871 24.3692 89.8167 20.348C85.8452 15.1192 80.8826 10.7238 75.2124 7.41289C69.5422 4.10194 63.2754 1.94025 56.7698 1.05124C51.7666 0.367541 46.6976 0.446843 41.7345 1.27873C39.2613 1.69328 37.813 4.19778 38.4501 6.62326C39.0873 9.04874 41.5694 10.4717 44.0505 10.1071C47.8511 9.54855 51.7191 9.52689 55.5402 10.0491C60.8642 10.7766 65.9928 12.5457 70.6331 15.2552C75.2735 17.9648 79.3347 21.5619 82.5849 25.841C84.9175 28.9121 86.7997 32.2913 88.1811 35.8758C89.083 38.2158 91.5421 39.6781 93.9676 39.0409Z" fill="currentColor" />
                                            </svg>
                                            <span x-text="isProcessSubmit ? 'Loading' : 'Simpan' "> </span>

                                        </button>
                                        <button
                                            x-on:click="closeCreateProduct"
                                            type="button"
                                            x-bind:disabled="isProcessSubmit == true"
                                            class="text-body bg-gray-200 box-border border border-default-medium hover:bg-gray-400 rounded-lg hover:text-heading focus:ring-4 focus:ring-neutral-tertiary shadow-xs font-medium leading-5 rounded-base text-sm px-4 py-2.5 focus:outline-none">
                                            Cancel
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>

                    {{-- end komponent toggle form create product --}}

                    {{-- start komponent card table product --}}
                    <div
                        x-show="isVisable == 'card-table'"
                        class="relative overflow-x-auto bg-neutral-primary-soft shadow-xs rounded-base border border-default">
                        @include('admin._card_table')
                    </div>

                    <div
                        x-show="isVisable == 'restock-product'"
                        class="fixed inset-0 z-50 flex items-center justify-center bg-black/50">

                        <div class="relative w-full max-w-lg p-4">

                            <div class="bg-white rounded-lg shadow-lg p-6">
                                @include('admin.card_restock_product')
                            </div>

                        </div>
                    </div>

                    {{-- end komponent table --}}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
