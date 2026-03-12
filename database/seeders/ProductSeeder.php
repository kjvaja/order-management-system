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
            'name'=>'iPhone 15',
            'price'=>80000,
            'stock'=>10,
            'status'=>'active'
            ],
            [
            'name'=>'Samsung S24',
            'price'=>75000,
            'stock'=>8,
            'status'=>'active'
            ],
            [
            'name'=>'Pixel 8',
            'price'=>70000,
            'stock'=>0,
            'status'=>'inactive'
            ]
        ]);
    }
}
