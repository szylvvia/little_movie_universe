<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class ArtistSeeder extends Seeder
{
    public function resizeImage($image)
    {
        $resizedImage = Image::make($image)->resize(200, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $imageData = $resizedImage->encode(null)->getEncoded();

        return $imageData;
    }
    public function run(): void
    {
        $artists = [
            [
                //1
                'name' => 'Cillian',
                'surname' => 'Murphy',
                'gender' => 'Male',
                'profession' => 'actor',
                'birth_date' => '1976-05-25',
                'death_date' => null,
                'description' => 'Irish actor, born in Douglas',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'status'=>'pending',
                'image' => $this->resizeImage(file_get_contents(public_path("img/artists/cillian_murphy.jpg"))),

            ],
            [
                //2
                'name' => 'Daryl',
                'surname' => 'McCormack',
                'gender' => 'Male',
                'profession' => 'actor',
                'birth_date' => '1993-01-22',
                'death_date' => null,
                'description' => 'Irish actor, played in PeakyBlinders',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'status'=>'pending',
                'image' => $this->resizeImage(file_get_contents(public_path("img/artists/mcCormack.jpg"))),
            ],
            [
                //3
                'name' => 'Emma',
                'surname' => 'Thompson',
                'gender' => 'Female',
                'profession' => 'actor',
                'birth_date' => '1959-04-15',
                'death_date' => null,
                'description' => 'Twice won an Oscar',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'status'=>'pending',
                'image' => $this->resizeImage(file_get_contents(public_path("img/artists/thompson.jpg"))),
            ],
            [
                //4
                'name' => 'Luca',
                'surname' => 'Guadagnino',
                'gender' => 'Male',
                'profession' => 'director',
                'birth_date' => '1971-08-10',
                'death_date' => null,
                'description' => 'Italian director, work on Call Me By Your Name',
                'user_id' => 3,
                'created_at' => now(),
                'updated_at' => now(),
                'status'=>'pending',
                'image' => $this->resizeImage(file_get_contents(public_path("img/artists/guadagnino.jpg"))),
            ],
            [
                //5
                'name' => 'Timothee',
                'surname' => 'Chalamet',
                'gender' => 'Male',
                'profession' => 'actor',
                'birth_date' => '1995-12-27',
                'death_date' => null,
                'description' => 'American actor',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'status'=>'pending',
                'image' => $this->resizeImage(file_get_contents(public_path("img/artists/tim.jpg"))),
            ],
            [
                //6
                'name' => 'Stan',
                'surname' => 'Lee',
                'gender' => 'Male',
                'profession' => 'producer',
                'birth_date' => '1922-12-28',
                'death_date' => '2018-11-12',
                'description' => 'American producer, screenwriter, author of Marvel\'s comics',
                'user_id' => 4,
                'created_at' => now(),
                'updated_at' => now(),
                'status'=>'pending',
                'image' => $this->resizeImage(file_get_contents(public_path("img/artists/lee.jpg"))),
            ],
            [
                //7
                'name' => 'Tom',
                'surname' => 'Holland',
                'gender' => 'Male',
                'profession' => 'actor',
                'birth_date' => '1996-06-01',
                'death_date' => null,
                'description' => 'British actor, played Peter Parker in Marvel\'s Spiderman series',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'status'=>'pending',
                'image' => $this->resizeImage(file_get_contents(public_path("img/artists/holland.jpg"))),
            ],
            [
                //8
                'name' => 'Zendaya',
                'surname' => 'Coleman',
                'gender' => 'Female',
                'profession' => 'actor',
                'birth_date' => '1996-09-01',
                'death_date' => null,
                'description' => 'American actress and singer.',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'status'=>'pending',
                'image' => $this->resizeImage(file_get_contents(public_path("img/artists/zendaya.jpg"))),
            ],
            [
                //9
                'name' => 'Christopher',
                'surname' => 'Nolan',
                'gender' => 'Male',
                'profession' => 'director',
                'birth_date' => '1970-07-30',
                'death_date' => null,
                'description' => 'American producer, director. One of the most valuable director in the world',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'status'=>'pending',
                'image' => $this->resizeImage(file_get_contents(public_path("img/artists/nolan.jpg"))),
            ],

        ];

        DB::table('artists')->insert($artists);
    }
}
