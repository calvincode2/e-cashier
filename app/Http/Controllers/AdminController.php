<?php
// penamaan alamat file didalam folder secara otomatis dibuat
namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Support\Facades\Validator;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Stock;
use Illuminate\Support\Facades\DB;

class AdminController extends Controller
{
    // fungsi untuk megambil data product berdasarkan productId
    public function getProductById($productId)
    {
        try {
            // mengambil data kedalam table product
            $product = Product::where('id', $productId)->with(['stocks' => function ($query) {
                $query->where('status', 'in-stock');
            }])->first();

            // menimpa nilai product quantity ke front-end
            $dataProduct = [
                'product_id'    => $product->id,
                'name'          => $product->name,
                'size'          => $product->size,
                'quantity'      => optional($product->stocks->first())->quantity ?? 0,
                'description'   => $product->description,
            ];

            // mengembalikan data response berbentuk json
            return response()->json([
                'message'   => 'get product successfully',
                'response'      => $dataProduct
            ]);
        } catch (\Exception $error) {
            // mengembalikan response error berbentuk json
            return response()->json([
                'message'   => $error->getMessage()
            ]);
        }
    }

    // pembuatan fungsi index untuk melemparkan tampilan halaman
    public function index()
    {
        return view('admin.index');
        // return view('admin.index_demo');
    }

    public function storeProduct(Request $request)
    {
        try {
            // melakukan validasi seluruh pengiriman request
            $validator = Validator::make($request->all(), [
                'name' => 'required|unique:products|min:3',
                'size' => 'required',
                'price' => 'required',
                'quantity' => 'required',
                'description' => 'required',
            ], [
                'name.required' => 'Nama produk wajib disi..',
                'size.required' => 'Ukuran Wajib dipilh',
                'price.required' => 'Harga produk wajib disi..',
                'quantity.required' => 'Jumlah produk wajib dipilih..',
                'description.required' => 'Keterangan produk wajib disi..',
            ]);

            // mengecek jika ada pengiriman yang tidak sesuai required
            if ($validator->fails()) {
                return response()->json([
                    'errors'    => $validator->errors()
                ], 422);
            }

            // mengumpulkan seluruh data request kedalam array
            $validated = $validator->validated();

            // melakukan insert data kedalam table products
            DB::table('products')->insert([
                'name' =>  $validated['name'],
                'size' => $validated['size'],
                'price' => $validated['price'],
                'description' => $validated['description'],
            ]);

            // mengambil data id product
            $productId = DB::getPdo()->lastInsertId();

            // melakukan insert data ke table stocks
            DB::insert(
                'INSERT INTO stocks
            (quantity, product_id, status, created_by, created_at) values
            (?, ?, ?, ?, ?)',
                [
                    $validated['quantity'],
                    $productId,
                    'in-stock',
                    auth()->user()->name,
                    now()
                ]
            );

            // mengirim response berhasil ke front-end
            return response()->json([
                'message'    => 'Created product successfully'
            ], 201);
        } catch (\Exception $error) {
            return response()->json([
                'errors'    => $error->getMessage()
            ], 500);
        }
    }

    public function deleteProduct($productId)
    {
        try {
            // menemukan data product
            $product = Product::with('stocks')->findOrFail($productId);
            if ($product->stocks()->exists()) {
                // menghapus data product stock
                $product->stocks()->delete();
                $product->delete();
            } else {
                // menghapus data product
                $product->delete();
            }

            return response()->json([
                'message' => "Product berhasil dihapus"
            ], 200);
        } catch (\Exception $error) {
            return response()->json([
                'message' => $error->getMessage()
            ], 500);
        }
    }

    // membuat fungsi untuk mengambil data product beserta relasi table stock
    public function getListProduct()
    {
        try {
            // mengubah query untuk mengambil data product dengan relasi stocks dimana status adalah in-stock
            $listProduct = Product::with(['stocks' => function ($query) {
                $query->where('status', 'in-stock')->latest();
            }])->get();

            // merubah format response API dengan cara maping data
            $dataListProduct = $listProduct->map(function ($product) {
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

            // mengembalikan data product berbentuk response json
            return response()->json([
                'message'   => 'get data list product successfully',
                'data'      => $dataListProduct
            ]);
        } catch (\Exception $error) {
            // mengembalikan pesan error berbentuk response json
            return response()->json([
                'message'   => $error->getMessage()
            ], 500); // mengembalikan pesan error internal server error
        }
    }

    public function getProduct(string $productId)
    {
        try {
            // menyeleksi kolom yang akan ditampilkan
            $selectColum = [
                'products.id as product_id',
                'products.name as product_name',
                'products.price as product_price',
                'products.size as product_size',
                'products.description as product_description',
                'stocks.id as stock_id',
                'stocks.product_id as stock_product_id',
                'stocks.quantity as stock_quantity',
                'stocks.status as stock_status',
                'stocks.created_by as stock_created_by'
            ];
            // mengambil data product kedalam table products melalui model Product
            $dataProduct = DB::table('products')
                ->leftJoin('stocks', 'products.id', '=', 'stocks.product_id')
                ->where('stocks.status', 'in-stock')->orderByDesc('stocks.created_at')
                ->select($selectColum)
                ->where('products.id', $productId)->first();
            // mengembalikan data product ke FE seperti yang diharapkan
            return response()->json([
                'message'   => 'get product succcessfuly',
                'response'  => $dataProduct
            ], 200);
        } catch (\Exception $error) {
            // mengembalikan response berbentuk json ketika ada error typo nama table yg digunakan
            return response()->json([
                'error'   => $error->getMessage()
            ], 500);
        }
    }

    public function restockProduct(Request $request, string $stockId)
    {
        try {

            $validator = Validator::make(
                $request->all(),
                [
                    'status' => 'required',
                    'quantity' => 'required|integer|min:1',
                    'product_id' => 'required'
                ],
                [
                    'quantity.required' => 'Jumlah stock wajib diisi...',
                    'status.required' => 'Status wajib diisi'
                ]
            );

            if ($validator->fails()) {
                return response()->json([
                    'errors' => $validator->errors()
                ], 422);
            }

            $validated = $validator->validated();

            $stock = Stock::where('product_id', $validated['product_id'])
                ->where('status', 'in-stock')
                ->first();

            if (!$stock) {
                return response()->json([
                    'message' => 'Stock tidak ditemukan'
                ], 404);
            }

            $increaseStatus = ['re-stock'];
            $decreaseStatus = ['returned', 'damaged'];

            $allowedStatus = ['re-stock', 'returned', 'damaged'];

            if (!in_array($validated['status'], $allowedStatus)) {
                return response()->json([
                    'errors' => [
                        'status' => ['Status tidak valid']
                    ]
                ], 422);
            }
            if (in_array($validated['status'], $increaseStatus)) {

                $resultStock = $stock->quantity + $validated['quantity'];
            } elseif (in_array($validated['status'], $decreaseStatus)) {

                if ($validated['quantity'] > $stock->quantity) {
                    return response()->json([
                        'errors' => [
                            'quantity' => ['Jumlah melebihi stock']
                        ]
                    ], 422);
                }

                $resultStock = $stock->quantity - $validated['quantity'];
            }

            $stock->update([
                'quantity' => $resultStock
            ]);

            Stock::create([
                'quantity' => $validated['quantity'],
                'status' => $validated['status'],
                'created_by' => auth()->user()->name,
                'product_id' => $validated['product_id']
            ]);

            return response()->json([
                'message' => 'Restock berhasil'
            ], 201);
        } catch (\Exception $error) {

            return response()->json([
                'message' => $error->getMessage()
            ], 500);
        }
    }

    public function historyPage()
    {
        $orders = Order::with(["orderDetail"])->get();
        return view("admin.history", compact('orders'));
    }
}
