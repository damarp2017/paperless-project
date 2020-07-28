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
            'image' => 'https://paperless-project.s3-ap-southeast-1.amazonaws.com/default/user-profile.png',
            'email' => "damarp2017@gmail.com",
            'password' => Hash::make("12345678"),
            'email_verified_at' => now(),
            'api_token' => "IniTokenManualHanyaUntukTest-Damar",
        ]);

        User::create([
            'name' => "Prieyudha Akadita S",
            'image' => 'https://paperless-project.s3-ap-southeast-1.amazonaws.com/default/user-profile.png',
            'email' => "akaditasustono@gmail.com",
            'password' => Hash::make("12345678"),
            'email_verified_at' => now(),
            'api_token' => "IniTokenManualHanyaUntukTest-Yudha"
        ]);

        User::create([
            'name' => "Izzatur Royhan",
            'image' => 'https://paperless-project.s3-ap-southeast-1.amazonaws.com/default/user-profile.png',
            'email' => "royhan@gmail.com",
            'password' => Hash::make("12345678"),
            'email_verified_at' => now(),
            'api_token' => "IniTokenManualHanyaUntukTest-Izza"
        ]);
    }
}
