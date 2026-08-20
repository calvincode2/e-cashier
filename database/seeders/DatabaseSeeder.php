<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'admin@admin.com',
            'password'  => bcrypt('password'),
            'role'      => 'admin'
        ]);

        \App\Models\User::factory()->create([
            'name' => 'Test User',
            'email' => 'cashier@cashier.com',
            'password'  => bcrypt('password'),
            'role'      => 'cashier'
        ]);

        $this->call([
            CustomerSeeder::class,
            OrderSeeder::class,
            OrderDetailSeeder::class,
            ProductSeeder::class,
            StockSeeder::class
        ]);
    }
}
