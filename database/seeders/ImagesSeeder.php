<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class ImagesSeeder extends Seeder
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
        $movieHasImages =
            [
                [
                    //oppenheimer
                    'movie_id' => 1,
                    'image' => $this->resizeImage(file_get_contents(public_path("img/images/o1.jpeg")),600),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'movie_id' => 1,
                    'image' => $this->resizeImage(file_get_contents(public_path("img/images/o2.png")),600),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    //goodluck
                    'movie_id' => 2,
                    'image' => $this->resizeImage(file_get_contents(public_path("img/images/p1.jpg")),600),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'movie_id' => 2,
                    'image' => $this->resizeImage(file_get_contents(public_path("img/images/p2.jpg")),600),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    //inception
                    'movie_id' => 3,
                    'image' => $this->resizeImage(file_get_contents(public_path("img/images/i1.jpg")),600),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'movie_id' => 3,
                    'image' => $this->resizeImage(file_get_contents(public_path("img/images/i2.jpg")),600),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    //callme
                    'movie_id' => 4,
                    'image' => $this->resizeImage(file_get_contents(public_path("img/images/t1.jpeg")),600),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'movie_id' => 4,
                    'image' => $this->resizeImage(file_get_contents(public_path("img/images/t2.jpeg")),600),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    //dunkirk
                    'movie_id' => 5,
                    'image' => $this->resizeImage(file_get_contents(public_path("img/images/d1.png")),600),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'movie_id' => 5,
                    'image' => $this->resizeImage(file_get_contents(public_path("img/images/d2.jpg")),600),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    //dune
                    'movie_id' => 6,
                    'image' => $this->resizeImage(file_get_contents(public_path("img/images/di1.jpg")),600),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'movie_id' => 6,
                    'image' => $this->resizeImage(file_get_contents(public_path("img/images/di2.jpg")),600),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    //spiderman
                    'movie_id' => 7,
                    'image' => $this->resizeImage(file_get_contents(public_path("img/images/s1.jpg")),600),
                    'created_at' => now(),
                    'updated_at' => now(),
                ],
                [
                    'movie_id' => 7,
                    'image' => $this->resizeImage(file_get_contents(public_path("img/images/s2.jpg")),600),
                    'created_at' => now(),
                    'updated_at' => now(),
                ]
            ];
        DB::table('images')->insert($movieHasImages);
    }
}
