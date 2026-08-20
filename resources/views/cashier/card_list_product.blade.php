<div>
    <h2 class="mt-6 text-xl font-semibold">
        List Product
    </h2>

    <div class="grid grid-cols-2 gap-2 mt-4">

        <!-- Jika ada produk yang stoknya > 0 -->
        <template x-if="listProduct.length > 0">
            <template x-for="product in listProduct" :key="product.id">
                <template x-if="product.stocks.quantity > 0">
                    <div class="w-full max-w-sm bg-white border border-gray-100 rounded-lg p-2">
                        <img class="rounded-lg p-1" src="https://images.unsplash.com/photo-1555215695-3004980ad54e?w=1200"
                            alt="product image">

                        <div>
                            <h5 class="text-xl font-semibold" x-text="product.name"></h5>

                            <p class="text-sm text-gray-500">
                                Stok:
                                <span class="font-semibold" x-text="product.stocks.quantity"></span>
                            </p>

                            <p class="mt-1 text-sm text-gray-500" x-text="product.description"></p>

                            <div class="flex items-center justify-between mt-6">
                                <span class="text-xl font-extrabold" x-text="formatRupiah(product.price)"></span>

                                <button x-on:click="addProductToCart(product)"
                                    x-bind:disabled="productOnCart(product.id)"
                                    class="inline-flex items-center text-white bg-red-600 hover:bg-red-800 rounded-lg text-sm px-3 py-2 disabled:bg-red-900 disabled:cursor-not-allowed">
                                    <span x-text="productOnCart(product.id) ? 'Added' : 'Add To Cart'"></span>
                                </button>
                            </div>
                        </div>
                    </div>
                </template>
            </template>
        </template>

        <!-- Jika semua stok habis atau tidak ada produk -->
        <template x-if="listProduct.filter(product => product.stocks.quantity > 0).length === 0">
            <div class="col-span-2 text-center py-8">
                <p class="text-red-500 text-lg">Tidak ada produk.</p>
            </div>
        </template>

    </div>
</div>
