<?php

namespace Database\Seeders;

use App\Models\Customer;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CustomerSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Customer::insert([
            [
                'company_name' => 'PT Sumber Makmur',
                'contact_name' => 'Budi Santoso',
                'address' => 'Jl. Ahmad Yani No. 12',
                'city' => 'Batam',
                'postal_code' => '29444',
                'country' => 'Indonesia',
                'phone' => '081234567890',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_name' => 'CV Maju Bersama',
                'contact_name' => 'Andi Wijaya',
                'address' => 'Jl. Sudirman No. 45',
                'city' => 'Jakarta',
                'postal_code' => '10110',
                'country' => 'Indonesia',
                'phone' => '082345678901',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_name' => 'PT Nusantara Jaya',
                'contact_name' => 'Siti Rahma',
                'address' => 'Jl. Diponegoro No. 88',
                'city' => 'Bandung',
                'postal_code' => '40123',
                'country' => 'Indonesia',
                'phone' => '083456789012',
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'company_name' => 'PT Yasir Jaya',
                'contact_name' => 'Rahmat Kasip',
                'address' => 'Jl. Mangga No. 88',
                'city' => 'Medan',
                'postal_code' => '45834',
                'country' => 'Indonesia',
                'phone' => '088756569672',
                'created_at' => now(),
                'updated_at' => now(),
            ]
        ]);
    }
}
