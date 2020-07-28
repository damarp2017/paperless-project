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

        User::create([
            'name' => "Helfanza Nanda Alfara",
            'image' => 'https://paperless-project.s3-ap-southeast-1.amazonaws.com/default/user-profile.png',
            'email' => "elfan@gmail.com",
            'password' => Hash::make("12345678"),
            'email_verified_at' => now(),
            'api_token' => "IniTokenManualHanyaUntukTest-Elfan"
        ]);

        User::create([
            'name' => "Abu Muslih Assulkhani",
            'image' => 'https://paperless-project.s3-ap-southeast-1.amazonaws.com/default/user-profile.png',
            'email' => "abu@gmail.com",
            'password' => Hash::make("12345678"),
            'email_verified_at' => now(),
            'api_token' => "IniTokenManualHanyaUntukTest-Abu"
        ]);

        User::create([
            'name' => "Ikhwanudin",
            'image' => 'https://paperless-project.s3-ap-southeast-1.amazonaws.com/default/user-profile.png',
            'email' => "ikhwan@gmail.com",
            'password' => Hash::make("12345678"),
            'email_verified_at' => now(),
            'api_token' => "IniTokenManualHanyaUntukTest-Ikhwan"
        ]);

        User::create([
            'name' => "Afif Maulana",
            'image' => 'https://paperless-project.s3-ap-southeast-1.amazonaws.com/default/user-profile.png',
            'email' => "afif@gmail.com",
            'password' => Hash::make("12345678"),
            'email_verified_at' => now(),
            'api_token' => "IniTokenManualHanyaUntukTest-Afif"
        ]);

        User::create([
            'name' => "Ibnu Subhan",
            'image' => 'https://paperless-project.s3-ap-southeast-1.amazonaws.com/default/user-profile.png',
            'email' => "ibnu@gmail.com",
            'password' => Hash::make("12345678"),
            'email_verified_at' => now(),
            'api_token' => "IniTokenManualHanyaUntukTest-Ibnu"
        ]);
    }
}
