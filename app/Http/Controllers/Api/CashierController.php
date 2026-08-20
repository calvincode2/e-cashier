<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class CashierController extends Controller
{
    public function getListProduct()
    {
        dd('mengambil produk');
    }

    public function getCustomer()
    {
        try {
            $customers = Customer::all();
            return response()->json([
                'message' => 'get customer successfully',
                'data' => $customers
            ], 201);
        } catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage()
            ], 500);
        }
    }

    public function storeCustomer(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'company_name' => 'required|unique:customers',
                'contact_name' => 'required',
                'address' => 'required',
                'city' => 'required',
                'postal_code' => 'required',
                'country' => 'required',
                'phone' => 'required'
            ], [
                'company_name.required' => 'nama perusahaan produk wajib disi..',
                'contact_name.required' => 'kontak Wajib dipilh',
                'address.required' => 'alamat produk wajib disi..',
                'city.required' => 'kota produk wajib dipilih..',
                'postal_code.required' => 'kode pos produk wajib disi..',
                'country.required' => 'negara wajib diisi..',
                'phone.required' => 'nomor telepon wajib diisi..'
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            $validated = $validator->validated();

            $id = DB::table('customers')->insertGetId([
                'company_name' =>  $validated['company_name'],
                'contact_name' => $validated['contact_name'],
                'address' => $validated['address'],
                'city' => $validated['city'],
                'postal_code' => $validated['postal_code'],
                'country' => $validated['country'],
                'phone' => $validated['phone'],
            ]);

            $customer = DB::table('customers')->find($id);

            return response()->json([
                'message' => 'store customer successfully',
                'data' => $customer
            ], 201);
        } catch (\Exception $error) {
            return response()->json([
                'error' => $error->getMessage()
            ]);
        }
    }

    public function deleteCustomer(string $id)
    {
        try {
            $customer = Customer::where('id', $id)->first();
            $customer->delete();
            return response()->json([
                'message' => 'berhasil menghapus customer'
            ], 200);
        } catch (\Exception $error) {
            return response()->json([
                'message' => "gagal menghapus customer",
                'error' => $error->getMessage()
            ], 500);
        }
    }

    public function getOrderDetailCustomer(string $customerId)
    {
        try {
            $orders = Order::with('orderDetails')->where("customer_id", $customerId)->get();
            return response()->json([
                'message' => 'get order detail successfully',
                'data' => $orders
            ], 200);
        } catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage()
            ], 500);
        }
    }
    public function storeOrder(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'jumlah_uang' => 'required|integer',
                'type' => 'required|string',
                'order_product' => 'required|array',
            ], [
                'jumlah_uang.required' => 'jumlah uang produk wajib disi..',
                'jumlah_uang.integer' => 'inputan harus nominal angka..',
                'type.required' => 'type request Wajib dipilh..',
                'type.string' => 'inputan harus karakter..',
                'order_product.required' => 'order produk wajib disi..',
                'order_product.array' => 'order produk lebih dari 1 item..',
            ]);

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }
            $validated = $validator->validated();
             dd(Auth::user());
            DB::transaction(function () use ($validated) {
                // ambil semua produk id dan ubah jadi array
                $productIds = collect($validated['order_product'])->pluck('product_id');
                // ambil semua data lewat productIds
                $listProduct = Product::with('stocks')->whereIn('id', $productIds)->get()->keyBy('id');

                // variable penampung harga total item
                $totalHarga = array_reduce($validated['order_product'], function ($acc, $item) {
                    return $acc + ($item['qty'] * $item['price']);
                }, 0);

                $totalItem = array_reduce($validated['order_product'], function ($acc, $item) {
                    return $acc + $item['qty'];
                }, 0);


                $order = Order::create([
                    'customer_id' => $validated['type'] == 'mobile' ? auth()->id() : null,
                    'quantity' => $totalItem,
                    'user_id' => $validated['type'] == 'website' ? auth()->id() : null,
                    'kode_invoice' => Str::random(10),
                    'price' => $totalHarga,
                    'type' => $validated['type']
                ]);

                // melakukan perulangan bagian order product
                foreach ($validated['order_product'] as $itemOrder) {
                    $product = $listProduct[$itemOrder['product_id']];
                    // membuat storeOrder

                    // mengambil qty

                    // mengambil jumlah stok dari objek produk
                    $stockProduct = $product->stocks->first();
                    $stockProduct->decrement('quantity', $itemOrder['qty']);
                    // mengurangi stok dari table stok
                }
            });


            return response()->json([
                'message' => 'transaksi berhasil'
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage()
            ], 500);
        }
    }

}
