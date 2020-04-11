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
            'name' => 'indomie',
            'description' => 'deskripsi produk indomie',
            'price' => 2500,
            'quantity' => 100
        ]);

        \App\Product::create([
            'category_id' => 2,
            'store_id' => 1,
            'name' => 'coffee homemade',
            'description' => 'deskripsi produk coffee homemade',
            'price' => 5000,
        ]);


        \App\Product::create([
            'category_id' => 1,
            'store_id' => 2,
            'name' => 'supermieee',
            'description' => 'deskripsi produk supermiee',
            'price' => 3500,
            'quantity' => 50
        ]);

        \App\Product::create([
            'category_id' => 2,
            'store_id' => 2,
            'name' => 'es poci',
            'description' => 'deskripsi produk es poci',
            'price' => 5000,
        ]);
    }
}
