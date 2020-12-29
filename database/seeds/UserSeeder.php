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
            'image' => 'https://res.cloudinary.com/damarp2017/image/upload/v1607499791/default/user_wttbnf.png',
            'email' => "damarp2017@gmail.com",
            'password' => Hash::make("12345678"),
            'email_verified_at' => now(),
            'api_token' => "IniTokenManualHanyaUntukTest-Damar",
        ]);

        User::create([
            'name' => "Prieyudha Akadita S",
            'image' => 'https://res.cloudinary.com/damarp2017/image/upload/v1607499791/default/user_wttbnf.png',
            'email' => "akaditasustono@gmail.com",
            'password' => Hash::make("12345678"),
            'email_verified_at' => now(),
            'api_token' => "IniTokenManualHanyaUntukTest-Yudha"
        ]);

        User::create([
            'name' => "Izzatur Royhan",
            'image' => 'https://res.cloudinary.com/damarp2017/image/upload/v1607499791/default/user_wttbnf.png',
            'email' => "royhan@gmail.com",
            'password' => Hash::make("12345678"),
            'email_verified_at' => now(),
            'api_token' => "IniTokenManualHanyaUntukTest-Izza"
        ]);

        User::create([
            'name' => "Helfanza Nanda Alfara",
            'image' => 'https://res.cloudinary.com/damarp2017/image/upload/v1607499791/default/user_wttbnf.png',
            'email' => "elfan@gmail.com",
            'password' => Hash::make("12345678"),
            'email_verified_at' => now(),
            'api_token' => "IniTokenManualHanyaUntukTest-Elfan"
        ]);

        User::create([
            'name' => "Abu Muslih Assulkhani",
            'image' => 'https://res.cloudinary.com/damarp2017/image/upload/v1607499791/default/user_wttbnf.png',
            'email' => "abu@gmail.com",
            'password' => Hash::make("12345678"),
            'email_verified_at' => now(),
            'api_token' => "IniTokenManualHanyaUntukTest-Abu"
        ]);

        User::create([
            'name' => "Ikhwanudin",
            'image' => 'https://res.cloudinary.com/damarp2017/image/upload/v1607499791/default/user_wttbnf.png',
            'email' => "ikhwan@gmail.com",
            'password' => Hash::make("12345678"),
            'email_verified_at' => now(),
            'api_token' => "IniTokenManualHanyaUntukTest-Ikhwan"
        ]);

        User::create([
            'name' => "Afif Maulana",
            'image' => 'https://res.cloudinary.com/damarp2017/image/upload/v1607499791/default/user_wttbnf.png',
            'email' => "afif@gmail.com",
            'password' => Hash::make("12345678"),
            'email_verified_at' => now(),
            'api_token' => "IniTokenManualHanyaUntukTest-Afif"
        ]);

        User::create([
            'name' => "Ibnu Subhan",
            'image' => 'https://res.cloudinary.com/damarp2017/image/upload/v1607499791/default/user_wttbnf.png',
            'email' => "ibnu@gmail.com",
            'password' => Hash::make("12345678"),
            'email_verified_at' => now(),
            'api_token' => "IniTokenManualHanyaUntukTest-Ibnu"
        ]);
    }
}
