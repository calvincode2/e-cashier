<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderDetail;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class CashierController extends Controller
{
    public function index()
    {
        return view('cashier.dashboard');
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

            $order = DB::transaction(function () use ($validated) {
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

                $data = [];
                // melakukan perulangan bagian order product
                foreach ($validated['order_product'] as $itemOrder) {
                    $product = $listProduct[$itemOrder['product_id']];
                    // membuat storeOrderDetail
                    $data[] = [
                        'product_id' => $product->id,
                        'order_id' => $order->id,
                        'quantity' => $itemOrder['qty'],
                        'price' => $itemOrder['qty'] * $itemOrder['price'],
                        'created_at' => now(),
                    ];
                    // mengambil qty

                    // mengambil jumlah stok dari objek produk
                    $stockProduct = $product->stocks->first();
                    $stockProduct->decrement('quantity', $itemOrder['qty']);
                    // mengurangi stok dari table stok
                }

                OrderDetail::insert($data);
                return $order;
            });

            $listProduct = Product::with(['stocks' => function ($query) {
                $query->where('status', 'in-stock')->latest();
            }])->get();

            $product = $listProduct->map(function ($product) {
                return [
                    'id'            => $product->id,
                    'name'          => $product->name,
                    'size'          => $product->size,
                    'price'         => $product->price,
                    'description'   => $product->description,
                    'stocks' => [
                        'quantity' => optional($product->stocks->first())->quantity ?? 0,
                        'status' => optional($product->stocks->first())->status,
                    ],
                ];
            });

            dd($product);

            $data_response = [
                'total_uang' => $validated['jumlah_uang'],
                'kembalian' => $validated['jumlah_uang'] - $order->price,
                'product' => $product
            ];

            return response()->json([
                'message' => 'transaksi berhasil calvin',
                'response' => $data_response
            ], 201);
        } catch (\Throwable $th) {
            return response()->json([
                'message' => $th->getMessage(),
            ], 500);
        }
    }
}
