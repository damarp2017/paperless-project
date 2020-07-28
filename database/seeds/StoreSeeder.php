<?php

use App\Store;
use Illuminate\Database\Seeder;

class StoreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Store::create([
            'name' => 'Toko Damar',
            'store_logo' => 'https://paperless-project.s3.ap-southeast-1.amazonaws.com/default/store-logo.png',
            'description' => 'Ini adalah deskripsi toko damar',
            'email' => 'damarp2017@gmail.com',
            'phone' => '08996308805',
            'address' => 'Cabawan',
            'owner_id' => 1,
        ]);

        Store::create([
            'name' => 'Toko Yudha',
            'store_logo' => 'https://paperless-project.s3.ap-southeast-1.amazonaws.com/default/store-logo.png',
            'description' => 'Ini adalah deskripsi toko yudha keling',
            'email' => 'akaditasustono@gmail.com',
            'phone' => '08996308805',
            'address' => 'Cabawan Tengah',
            'owner_id' => 2,
        ]);
    }
}
