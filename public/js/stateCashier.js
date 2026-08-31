function stateCashierDashboard() {
    return {
        listProduct: [],

        listProductOnCart:[],

        alertMessage: {list_product: '', success_order: '', warning_order: ''},

        dataOrderProduct: {jumlah_uang: 0, order_product: [], type: 'website', uang_kembalian: 0},

        total_pembayaran: 0,

        init() {
            this.getListProduct()
        },

        formatRupiah(value){
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'idr',
                minimumFractionDigits: 0
            }).format(value)
        },

        async getListProduct() {
            // menggunakan try and catch agar menghandle kondisi error bila data tidak
            try {
                // mengambil data melalui url yang sudah disediakan dari BE
                const result = await axios.get('list-product')

                // memasukkan data kedalam variable array listProduct
                this.listProduct = result.data.data

                console.log('data dari BE', this.listProduct)
                this.alertMessage.list_product = this.listProduct.length > 0 ? this.listProduct : 'data produk belum tersedia'
            } catch (error) {
                // menampilkan pesan error kedalam console
                console.log('error', error)
            } finally {
                // tandai bahwa data sudah selesai dimuat (berhasil atau gagal)
                this.isEmpty = true
            }
        },

        addProductToCart(product){
            let productExist = this.listProductOnCart.find(item => item.id == product.id)
            if(productExist){
                productExist.qty += 1
            }else{
                this.listProductOnCart.push({
                    ... product,
                    qty: 1,
                    stock: product.stocks.quantity
                })
            }
            console.log('data produk dalam keranjang', this.listProductOnCart)
        },

        removeProductFromCart(productId){
            this.listProductOnCart = this.listProductOnCart.filter(item => item.id !== productId);
        },

        decrementQty(product){
            if(product.qty > 1){
                product.qty--
            }

        },

        incrementQty(product){
            if(product.qty < product.stock){
                product.qty++
            }
        },

        productOnCart(productId){
            return this.listProductOnCart.some(item => item.id == productId)
        },
        async btnBayar(){
            try {
                this.total_pembayaran = this.listProductOnCart.reduce((sum, product) => sum + (product.price * product.qty), 0)
                this.alertMessage.warning_order = this.dataOrderProduct.jumlah_uang < this.total_pembayaran ? 'uang tidak cukup' : ''
                this.dataOrderProduct.order_product = this.listProductOnCart.map((productOrder) => ({
                    product_id: productOrder.id,
                    qty: productOrder.qty,
                    price:productOrder.price
                }))
                let result = await axios.post(`checkout-order`, this.dataOrderProduct)
                this.dataOrderProduct.uang_kembalian = result.data.response.kembalian
                this.alertMessage.success_order = result.data.message
                setTimeout(() => {
                    this.alertMessage.success_order = result.data.message
                }, 1500)
                console.log('data yang mau dikirim', result.data.response.kembalian)
            } catch (error) {
                console.log('error', error)
            }

        },
    }
}
