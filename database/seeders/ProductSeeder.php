<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    public function run()
    {
        $products = [
            [
                'name' => 'Smartphone Android',
                'description' => 'High-quality Android smartphone with great features',
                'price' => 2999000.00,
                'stock' => 50,
                'sku' => 'PHONE-001',
                'category_id' => 1,
                'weight' => 0.2,
                'is_featured' => true,
            ],
            [
                'name' => 'Laptop Gaming',
                'description' => 'Powerful gaming laptop for professionals',
                'price' => 15999000.00,
                'stock' => 20,
                'sku' => 'LAPTOP-001',
                'category_id' => 1,
                'weight' => 2.5,
                'is_featured' => true,
            ],
            [
                'name' => 'T-Shirt Cotton',
                'description' => 'Comfortable cotton t-shirt',
                'price' => 99000.00,
                'stock' => 100,
                'sku' => 'TSHIRT-001',
                'category_id' => 2,
                'weight' => 0.2,
                'is_featured' => false,
            ],
        ];

        foreach ($products as $product) {
            Product::create([
                'name' => $product['name'],
                'slug' => \Str::slug($product['name']),
                'description' => $product['description'],
                'price' => $product['price'],
                'stock' => $product['stock'],
                'sku' => $product['sku'],
                'category_id' => $product['category_id'],
                'weight' => $product['weight'],
                'is_featured' => $product['is_featured'],
                'is_active' => true,
                'images' => [],
            ]);
        }
    }
}
