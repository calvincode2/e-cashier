 <table class="w-full text-sm text-left rtl:text-right text-body">
     <thead class="text-sm text-body bg-neutral-secondary-medium border-b border-default-medium">
         <tr>
             <th scope="col" class="px-6 py-3 font-medium">
                 #
             </th>
             <th scope="col" class="px-6 py-3 font-medium">
                 Nama
             </th>
             <th scope="col" class="px-6 py-3 font-medium">
                 Harga
             </th>
             <th scope="col" class="px-6 py-3 font-medium">
                 Ukuran
             </th>
             <th scope="col" class="px-6 py-3 font-medium">
                 description
             </th>
             <th scope="col" class="px-6 py-3 font-medium">
                 Jumlah Stok
             </th>
             <th scope="col" class="px-6 py-3 font-medium">
                 <span class="sr-only">Edit</span>
             </th>
         </tr>
     </thead>
     <tbody>
         {{-- start melakukan pengecekan jika data listProduct lebih dari 0 --}}
         <template x-if="listProduct.length > 0">
             {{-- start melakukan perulangan--}}
             <template x-for="(product, index) in listProduct" :key="index">
                 <tr class="bg-neutral-primary-soft border-b border-default hover:bg-neutral-secondary-medium">
                     <th x-text="index + 1" scope="row" class="px-6 py-4 font-medium text-heading whitespace-nowrap">

                     </th>
                     <td x-text="product.name" class="px-6 py-4">

                     </td>
                     <td x-text="product.price" class="px-6 py-4">

                     </td>
                     <td x-text="product.size" class="px-6 py-4">

                     </td>
                     <td x-text="product.description" class="px-6 py-4">

                     </td>
                     <td class="px-6 py-4">
                         {{-- start pengecekan jumlah stok produk --}}
                         <button x-on:click="btnRestock(product.id)"
                             x-text="product.stocks.quantity || 0"
                             :class="product.stocks.quantity ? 'text-fg-brand hover:underline' : 'text-gray-400'"
                             type="button" class="font-medium text-fg-brand hover:underline">
                         </button>
                         {{-- end pengecekan jumlah stok produk --}}
                     </td>
                     <td class="px-6 py-4 gap-2 text-right inline-flex">
                         <button x-on:click="btnDeleteProduct(product.id)" type="button" class="font-medium text-fg-brand hover:underline">delete</button>
                     </td>
                 </tr>
             </template>
             {{-- end melakukan perulangan --}}
         </template>
         {{-- end melakukan pengecekan jika data listProduct lebih dari 0 --}}

     </tbody>
 </table>
