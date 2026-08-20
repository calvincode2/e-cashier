<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Product::insert([
            [
                'name' => 'Kemeja Formal Pria',
                'price' => 150000,
                'size' => 'L',
                'description' => 'Kemeja formal bahan katun berkualitas tinggi',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Kaos Polos Cotton Combed',
                'price' => 50000,
                'size' => 'M',
                'description' => 'Kaos polos nyaman adem dipakai sehari-hari',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Celana Chino Panjang',
                'price' => 200000,
                'size' => '32',
                'description' => 'Celana chino casual trendy',
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
