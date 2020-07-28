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
            'address' => 'Jalan Sunan Kalijaga No 17, Kaligangsa Wetan, Brebes',
            'owner_id' => 1,
        ]);

        Store::create([
            'name' => 'Toko Yudha',
            'store_logo' => 'https://paperless-project.s3.ap-southeast-1.amazonaws.com/default/store-logo.png',
            'description' => 'Ini adalah deskripsi toko yudha',
            'email' => 'akaditasustono@gmail.com',
            'phone' => '087780200002',
            'address' => 'Pasar Balamoa',
            'owner_id' => 2,
        ]);

        Store::create([
            'name' => 'Toko Izzatur',
            'store_logo' => 'https://paperless-project.s3.ap-southeast-1.amazonaws.com/default/store-logo.png',
            'description' => 'Ini adalah deskripsi toko izzatur',
            'email' => 'izza@gmail.com',
            'phone' => '087780200010',
            'address' => 'Desa Lengkong',
            'owner_id' => 3,
        ]);

        Store::create([
            'name' => 'Toko Helfanza',
            'store_logo' => 'https://paperless-project.s3.ap-southeast-1.amazonaws.com/default/store-logo.png',
            'description' => 'Ini adalah deskripsi toko helfanza',
            'email' => 'elfan@gmail.com',
            'phone' => '087788101901',
            'address' => 'Desa Panggung, Tegal',
            'owner_id' => 4,
        ]);

        Store::create([
            'name' => 'Toko Abu',
            'store_logo' => 'https://paperless-project.s3.ap-southeast-1.amazonaws.com/default/store-logo.png',
            'description' => 'Ini adalah deskripsi toko abu',
            'email' => 'abu@gmail.com',
            'phone' => '085200820189',
            'address' => 'Desa Purbayasa, Tegal',
            'owner_id' => 5,
        ]);
    }
}
