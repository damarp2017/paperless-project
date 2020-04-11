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
            'name' => 'foods'
        ]);

        \App\Category::create([
            'name' => 'drinks'
        ]);

        \App\Category::create([
            'name' => 'others'
        ]);
    }
}
