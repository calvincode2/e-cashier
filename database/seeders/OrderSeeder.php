<?php

namespace Database\Seeders;

use App\Models\Order;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Order::insert([
            [
                'customer_id'  => 1,
                'quantity'     => 2,
                'kode_invoice' => 'INV-20260730-001',
                'price'        => 50000,
            ],
            [
                'customer_id'  => 1,
                'quantity'     => 1,
                'kode_invoice' => 'INV-20260730-002',
                'price'        => 30000,
            ],
            [
                'customer_id'  => 2,
                'quantity'     => 3,
                'kode_invoice' => 'INV-20260730-003',
                'price'        => 75000,
            ],
            [
                'customer_id'  => 2,
                'quantity'     => 2,
                'kode_invoice' => 'INV-20260730-004',
                'price'        => 45000,
            ],
        ]);
    }
}
