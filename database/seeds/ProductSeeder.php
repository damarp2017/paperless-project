<?php

use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        // Produk toko damar
        \App\Product::create([
            'category_id' => 1,
            'store_id' => 1,
            'image' => 'https://res.cloudinary.com/damarp2017/image/upload/v1607499791/default/product_onf7hn.png',
            'name' => 'Indomie Goreng',
            'description' => 'Deskripsi produk indomie',
            'price' => 2500,
            'quantity' => 100
        ]);

        \App\Product::create([
            'category_id' => 1,
            'store_id' => 1,
            'image' => 'https://res.cloudinary.com/damarp2017/image/upload/v1607499791/default/product_onf7hn.png',
            'name' => 'Indomie Ayam Bawang',
            'description' => 'Deskripsi produk indomie',
            'price' => 2500,
            'quantity' => 100
        ]);

        \App\Product::create([
            'category_id' => 1,
            'store_id' => 1,
            'image' => 'https://res.cloudinary.com/damarp2017/image/upload/v1607499791/default/product_onf7hn.png',
            'name' => 'Indomie Soto',
            'description' => 'Deskripsi produk indomie',
            'price' => 2500,
            'quantity' => 100
        ]);

        \App\Product::create([
            'category_id' => 2,
            'store_id' => 1,
            'image' => 'https://res.cloudinary.com/damarp2017/image/upload/v1607499791/default/product_onf7hn.png',
            'name' => 'Kopi Nescafe',
            'description' => 'Deskripsi produk kopi nescafe',
            'price' => 2000,
            'quantity' => 20,
        ]);

        \App\Product::create([
            'category_id' => 2,
            'store_id' => 1,
            'image' => 'https://res.cloudinary.com/damarp2017/image/upload/v1607499791/default/product_onf7hn.png',
            'name' => 'Kopi Indocafe',
            'description' => 'Deskripsi produk kopi indocafe',
            'price' => 1500,
            'quantity' => 30,
        ]);



        // Produk toko yudha
        \App\Product::create([
            'category_id' => 2,
            'store_id' => 2,
            'image' => 'https://res.cloudinary.com/damarp2017/image/upload/v1607499791/default/product_onf7hn.png',
            'name' => 'es poci',
            'description' => 'deskripsi produk es poci',
            'price' => 3500,
        ]);

        \App\Product::create([
            'category_id' => 2,
            'store_id' => 2,
            'image' => 'https://res.cloudinary.com/damarp2017/image/upload/v1607499791/default/product_onf7hn.png',
            'name' => 'es poci susu',
            'description' => 'deskripsi produk es poci',
            'price' => 5000,
        ]);

        \App\Product::create([
            'category_id' => 2,
            'store_id' => 2,
            'image' => 'https://res.cloudinary.com/damarp2017/image/upload/v1607499791/default/product_onf7hn.png',
            'name' => 'es poci thaitea',
            'description' => 'deskripsi produk es poci',
            'price' => 5000,
        ]);

        \App\Product::create([
            'category_id' => 2,
            'store_id' => 2,
            'image' => 'https://res.cloudinary.com/damarp2017/image/upload/v1607499791/default/product_onf7hn.png',
            'name' => 'es poci jeruk',
            'description' => 'deskripsi produk es poci',
            'price' => 4000,
        ]);

        // produk toko izza
        \App\Product::create([
            'category_id' => 1,
            'store_id' => 3,
            'image' => 'https://res.cloudinary.com/damarp2017/image/upload/v1607499791/default/product_onf7hn.png',
            'name' => 'Donat',
            'description' => 'deskripsi produk donat',
            'price' => 1000,
        ]);

        \App\Product::create([
            'category_id' => 1,
            'store_id' => 3,
            'image' => 'https://res.cloudinary.com/damarp2017/image/upload/v1607499791/default/product_onf7hn.png',
            'name' => 'Donat Gula Bubuk',
            'description' => 'deskripsi produk donat',
            'price' => 1500,
        ]);

        \App\Product::create([
            'category_id' => 1,
            'store_id' => 3,
            'image' => 'https://res.cloudinary.com/damarp2017/image/upload/v1607499791/default/product_onf7hn.png',
            'name' => 'Donat Keju',
            'description' => 'deskripsi produk donat',
            'price' => 1500,
        ]);

        \App\Product::create([
            'category_id' => 1,
            'store_id' => 3,
            'image' => 'https://res.cloudinary.com/damarp2017/image/upload/v1607499791/default/product_onf7hn.png',
            'name' => 'Donat Coklat',
            'description' => 'deskripsi produk donat',
            'price' => 1500,
        ]);
    }
}
