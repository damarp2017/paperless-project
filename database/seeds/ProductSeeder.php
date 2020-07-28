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
        \App\Product::create([
            'category_id' => 1,
            'store_id' => 1,
            'image' => 'https://paperless-project.s3-ap-southeast-1.amazonaws.com/default/product-image.png',
            'name' => 'indomie',
            'description' => 'deskripsi produk indomie',
            'price' => 2500,
            'quantity' => 100
        ]);

        \App\Product::create([
            'category_id' => 2,
            'store_id' => 1,
            'image' => 'https://paperless-project.s3-ap-southeast-1.amazonaws.com/default/product-image.png',
            'name' => 'coffee homemade',
            'description' => 'deskripsi produk coffee homemade',
            'price' => 5000,
        ]);


        \App\Product::create([
            'category_id' => 1,
            'store_id' => 2,
            'image' => 'https://paperless-project.s3-ap-southeast-1.amazonaws.com/default/product-image.png',
            'name' => 'supermieee',
            'description' => 'deskripsi produk supermiee',
            'price' => 3500,
            'quantity' => 50
        ]);

        \App\Product::create([
            'category_id' => 2,
            'store_id' => 2,
            'image' => 'https://paperless-project.s3-ap-southeast-1.amazonaws.com/default/product-image.png',
            'name' => 'es poci',
            'description' => 'deskripsi produk es poci',
            'price' => 5000,
        ]);
    }
}
