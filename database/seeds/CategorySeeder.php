<?php

use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Category::create([
            'name' => 'Makanan'
        ]);

        \App\Category::create([
            'name' => 'Minuman'
        ]);

        \App\Category::create([
            'name' => 'Elektronik'
        ]);

        \App\Category::create([
            'name' => 'Jasa'
        ]);

        \App\Category::create([
            'name' => 'Lainnya'
        ]);
    }
}
