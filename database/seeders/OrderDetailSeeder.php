<?php

namespace Database\Seeders;

use App\Models\OrderDetail;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        OrderDetail::insert([
            // Order 1
            [
                'product_id' => 1,
                'order_id'   => 1,
                'quantity'   => 2,
                'price'      => 30000,
            ],
            [
                'product_id' => 2,
                'order_id'   => 1,
                'quantity'   => 1,
                'price'      => 25000,
            ],

            // Order 2
            [
                'product_id' => 3,
                'order_id'   => 2,
                'quantity'   => 3,
                'price'      => 45000,
            ],

            // Order 3
            [
                'product_id' => 1,
                'order_id'   => 3,
                'quantity'   => 2,
                'price'      => 50000,
            ],

            // Order 4
            [
                'product_id' => 2,
                'order_id'   => 4,
                'quantity'   => 1,
                'price'      => 15000,
            ],
            [
                'product_id' => 3,
                'order_id'   => 4,
                'quantity'   => 2,
                'price'      => 50000,
            ],
        ]);
    }
}
