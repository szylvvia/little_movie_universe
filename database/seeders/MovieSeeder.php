<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;

class MovieSeeder extends Seeder
{
    use WithFaker;

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
        $movies = [
            [
                'title' => "Oppenheimer",
                'release_date' => "2023-07-19",
                'description' => "About inventor atom's bomb",
                'trailer_link' => 'https://www.youtube.com/embed/uYPbbksJxIg?si=xNrSchejZ11i4OGw',
                'soundtrack_link' => 'https://open.spotify.com/embed/playlist/5dR1SrU8502qfde3BEACwI?utm_source=generator&theme=0',
                'status' => "pending",
                'poster' => $this->resizeImage(file_get_contents(public_path("img/posters/oppenheimer.jpg"))),
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => "Good Luck To You, Leo Grande",
                'release_date' => "2022-07-15",
                'description' => "About Nancy and Leo",
                'trailer_link' => 'https://www.youtube.com/embed/bz9TVJvTXVs?si=5DZ8DkFv06RCiVvS',
                'soundtrack_link' => 'https://open.spotify.com/embed/album/27saD7bPiFsrET0NL4YuqW?utm_source=generator&theme=0',
                'status' => "pending",
                'poster' => $this->resizeImage(file_get_contents(public_path("img/posters/powodzenia.jpg"))),
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => "Inception",
                'release_date' => "2010-07-30",
                'description' => "When brain is crime scene",
                'trailer_link' => 'https://www.youtube.com/embed/YoHD9XEInc0?si=9GuLi_0AVALnH2YO',
                'soundtrack_link' => 'https://open.spotify.com/embed/album/2qvA7HmSg1iM6XMiFF76dp?utm_source=generator&theme=0',
                'status' => "pending",
                'poster' => $this->resizeImage(file_get_contents(public_path("img/posters/incepcja.jpg"))),
                'user_id' => 2,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => "Call me by your name",
                'release_date' => "2010-07-30",
                'description' => "When brain is crime scene",
                'trailer_link' => 'https://www.youtube.com/embed/Z9AYPxH5NTM?si=bEs8qfYW4tulrCgA',
                'soundtrack_link' => 'https://open.spotify.com/embed/album/7K0x1O9gqMQlDwbMkyCCIM?utm_source=generator&theme=0',
                'status' => "pending",
                'poster' => $this->resizeImage(file_get_contents(public_path("img/posters/tamte.jpg"))),
                'user_id' => 1,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => "Dunkirk",
                'release_date' => "2017-07-13",
                'description' => "About sea operation called Dynamo",
                'trailer_link' => 'https://www.youtube.com/embed/ed6IhUUN-gI?si=oCL2dXWuQy4VRDgR',
                'soundtrack_link' => 'https://open.spotify.com/embed/album/1KpQPJOBWeL8kmnwCzYcg8?utm_source=generator&theme=0',
                'status' => "pending",
                'poster' => $this->resizeImage(file_get_contents(public_path("img/posters/dunkierka.jpg"))),
                'user_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => "Dune",
                'release_date' => "2021-09-03",
                'description' => "Mentally travel prince Paul Atryd",
                'trailer_link' => 'https://www.youtube.com/embed/Way9Dexny3w?si=vKAkPByW7Ly9hwEb',
                'soundtrack_link' => 'https://open.spotify.com/embed/album/56k8ay5oE5apR61WIeE4wQ?utm_source=generator&theme=0',
                'status' => "pending",
                'poster' => $this->resizeImage(file_get_contents(public_path("img/posters/dune.jpg"))),
                'user_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],
            [
                'title' => "Spider-Man: Homecoming",
                'release_date' => "2017-07-07",
                'description' => "Peter Parker discover his new skills",
                'trailer_link' => 'https://www.youtube.com/embed/rk-dF1lIbIg?si=puyle0k5TGLCALM2',
                'soundtrack_link' => 'https://open.spotify.com/embed/album/3Aao9FYpxQXuNrAPjJnud1?utm_source=generator&theme=0',
                'status' => "pending",
                'poster' => $this->resizeImage(file_get_contents(public_path("img/posters/spiderman.jpg"))),
                'user_id' => 3,
                'created_at' => now(),
                'updated_at' => now()
            ],

        ];
        DB::table('movies')->insert($movies);

    }
}
