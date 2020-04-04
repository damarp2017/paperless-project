<?php

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\User::create([
            'name' => "Damar Permadany",
            'email' => "damarp2017@gmail.com",
            'password' => \Illuminate\Support\Facades\Hash::make("12345678"),
            'email_verified_at' => now(),
            'api_token' => \Illuminate\Support\Str::random(80)
        ]);

        \App\User::create([
            'name' => "Prieyudha Akadita S",
            'email' => "akaditasustono@gmail.com",
            'password' => \Illuminate\Support\Facades\Hash::make("12345678"),
            'email_verified_at' => now(),
            'api_token' => \Illuminate\Support\Str::random(80)

        ]);
    }
}
