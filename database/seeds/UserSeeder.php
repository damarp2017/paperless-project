<?php

use App\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => "Damar Permadany",
            'email' => "damarp2017@gmail.com",
            'password' => Hash::make("12345678"),
            'email_verified_at' => now(),
            'api_token' => "IniTokenManualHanyaUntukTest-Damar"
        ]);

        User::create([
            'name' => "Prieyudha Akadita S",
            'email' => "akaditasustono@gmail.com",
            'password' => Hash::make("12345678"),
            'email_verified_at' => now(),
            'api_token' => "IniTokenManualHanyaUntukTest-Yudha"
        ]);

        User::create([
            'name' => "Izzatur Royhan",
            'email' => "royhan@gmail.com",
            'password' => Hash::make("12345678"),
            'email_verified_at' => now(),
            'api_token' => "IniTokenManualHanyaUntukTest-Izza"
        ]);
    }
}
