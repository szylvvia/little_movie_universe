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
                'gender' => 'Mężczyzna',
                'profession' => 'Aktor',
                'birth_date' => '1976-05-25',
                'death_date' => null,
                'description' => 'Irlandzki aktor urodzony w Douglas. Światową sławę zdobył dzięki udziałom w filmach Christophera Nolana oraz roli Tomasha Shelby w Peaky Blindersa',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'status'=>'verified',
                'image' => $this->resizeImage(file_get_contents(public_path("img/artists/cillian_murphy.jpg"))),

            ],
            [
                //2
                'name' => 'Tom',
                'surname' => 'Cruise',
                'gender' => 'Mężczyzna',
                'profession' => 'Aktor',
                'birth_date' => '1962-07-03',
                'death_date' => null,
                'description' => 'Amerykański aktor, jest jedną z najbardziej wpływowych osób w swiecie Hollywood',
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now(),
                'status'=>'pending',
                'image' => $this->resizeImage(file_get_contents(public_path("img/artists/tom.jpg"))),
            ],
            [
                //3
                'name' => 'Hans',
                'surname' => 'Zimmer',
                'gender' => 'Mężczyzna',
                'profession' => 'Kompozytor',
                'birth_date' => '1957-09-12',
                'death_date' => null,
                'description' => 'Jego dzieła muzyczne zaliczają się do najlepszych na świecie. Zdobywca dwóch Oscarów w kategorii najlepsza muzyka. Napisał muzykę do przeszło 120 filmów.',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'status'=>'pending',
                'image' => $this->resizeImage(file_get_contents(public_path("img/artists/hans.jpg"))),
            ],
            [
                //4
                'name' => 'Luca',
                'surname' => 'Guadagnino',
                'gender' => 'Mężczyzna',
                'profession' => 'Reżyser',
                'birth_date' => '1971-08-10',
                'death_date' => null,
                'description' => 'Włoski reżyser, pracował nad filmem Tamte dni, tamte noce.',
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
                'gender' => 'Mężczyzna',
                'profession' => 'Aktor',
                'birth_date' => '1995-12-27',
                'death_date' => null,
                'description' => 'Amerykański aktor, światową sławę zdobył wcielająć się w Elio w filmie Tamte dni, tamte noce.',
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now(),
                'status'=>'verified',
                'image' => $this->resizeImage(file_get_contents(public_path("img/artists/tim.jpg"))),
            ],
            [
                //6
                'name' => 'Stan',
                'surname' => 'Lee',
                'gender' => 'Mężczyzna',
                'profession' => 'Producent',
                'birth_date' => '1922-12-28',
                'death_date' => '2018-11-12',
                'description' => 'Amerykański producent, scenarzysta, autor kultowych komiksów Marvela',
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
                'gender' => 'Mężczyzna',
                'profession' => 'Aktor',
                'birth_date' => '1996-06-01',
                'death_date' => null,
                'description' => 'Brytyjski aktor, zagrał rolę Petera\'a Parker\'a w serii filmów o Spiderman\'ie',
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
                'gender' => 'Kobieta',
                'profession' => 'Aktor',
                'birth_date' => '1996-09-01',
                'death_date' => null,
                'description' => 'Amerykańska aktorka oraz piosenkarka.',
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
                'gender' => 'Mężczyzna',
                'profession' => 'Reżyser',
                'birth_date' => '1970-07-30',
                'death_date' => null,
                'description' => 'Amerykański reżyser i scenarzysta. Jeden z najbardziej cenionych osóbw świeci kina',
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
