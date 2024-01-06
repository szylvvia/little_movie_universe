<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class UserSeeder extends Seeder
{
    public function resizeImage($image, $width)
    {
        $resizedImage = Image::make($image)->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $imageData = $resizedImage->encode(null)->getEncoded();

        return $imageData;
    }

    public function run(): void
    {
        $image = $this->resizeImage(file_get_contents(public_path("img/user/guest.jpg")),100);
        $background = $this->resizeImage(file_get_contents(public_path("img/user/back_guest.jpg")),1000);
        $users = [
            [
                'name' => 'Sylwia',
                'surname' => 'Krzyszton',
                'birth_date' => '2000-09-10',
                'email' => 'sylwia@sylwia.com',
                'role' => 'user',
                'password' => Hash::make('sylwiasylwia'),
                'created_at' => now(),
                'updated_at' => now(),
                'image' => $this->resizeImage(file_get_contents(public_path("img/user/meImage.jpg")),100),
                'background' => $this->resizeImage(file_get_contents(public_path("img/user/meBackground.png")),1000)
            ],
            [
                'name' => 'Jan',
                'surname' => 'Kowalski',
                'birth_date' => '2001-11-10',
                'email' => 'jan@jan.com',
                'role' => 'user',
                'password' => Hash::make('janjanjan'),
                'created_at' => now(),
                'updated_at' => now(),
                'image' => $image,
                'background' => $background
            ],
            [
                'name' => 'Adam',
                'surname' => 'Nowak',
                'birth_date' => '2002-01-10',
                'email' => 'adam@adam.com',
                'role' => 'user',
                'password' => Hash::make('adamadam'),
                'created_at' => now(),
                'updated_at' => now(),
                'image' => $image,
                'background' => $background
            ],
            [
                'name' => 'Administartor',
                'surname' => 'Radosław',
                'birth_date' => '1999-11-10',
                'email' => 'admin@admin.com',
                'role' => 'admin',
                'password' => Hash::make('adminadmin'),
                'created_at' => now(),
                'updated_at' => now(),
                'image' => $image,
                'background' => $background
            ]
        ];

        DB::table('users')->insert($users);
    }
}
