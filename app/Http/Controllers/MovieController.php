<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Collection;
use App\Models\Movie;
use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use function PHPUnit\Framework\isEmpty;

class MovieController extends Controller
{
    public function showMovies()
    {
        $user = auth()->user();
        $movies = Movie::where('status','verified')->get();
        $movies->each(function ($movie) {
            $movie->release_date = Carbon::parse($movie->release_date)->format('d.m.Y');
        });
        foreach ($movies as $movie)
        {
            $averageRating = Rate::where('movie_id', $movie->id)->avg('rate');

            if ($user)
            {
                $fav = Collection::where([
                    'movie_id' => $movie->id,
                    'user_id' => $user->id,
                    'name' => 'favorite'
                ])->exists();

                $watch = Collection::where([
                    'movie_id' => $movie->id,
                    'user_id' => $user->id,
                    'name' => 'toWatch'
                ])->exists();

                $movie->isFav = $fav;
                $movie->isWatch = $watch;
            }
            $movie->avg = $averageRating;
        }

        $movies = $movies->sortByDesc('avg');

        return view("movies", compact('movies'));
    }


    public function addMovieForm()
    {
        $artist = Artist::all();
        return view("addMovie",compact('artist'));
    }

    public function changeTrailerLink($link)
    {
        if (str_contains($link, "embed"))
        {
            return $link;
        }

        return str_replace("watch?v=", "embed/", $link);
    }
    public function changeSoundtrackLink($link)
    {
        if (str_contains($link, "embed")) {
            return $link;
        } else {
            $i = strpos($link, "/album/");
            $prefix = substr($link, 0, $i);
            $suffix = substr($link, $i);

            if (!str_contains($suffix, "theme=")) {
                $suffix .= "?utm_source=generator&theme=0";
            }

            $middle = "/embed";
            return $prefix.$middle.$suffix;
        }
    }

    protected function checkImage()
    {
        return ['image', 'mimes:jpeg,png,jpg', 'mimetypes:image/jpeg,image/png,image/jpg', 'max: 16777215', function ($attribute, $value, $fail) {
            $allowedExtensions = ['jpeg', 'png', 'jpg'];
            $extension = pathinfo($value->getClientOriginalName(), PATHINFO_EXTENSION);

            if ($extension === 'bin' || !in_array($extension, $allowedExtensions)) {
                $fail("The $attribute must be a file of type: " . implode(', ', $allowedExtensions));
            }

            if ($value->getSize() > 5242880) {
                $fail("The $attribute must not be larger than 5 MB.");
            }
        }];
    }
    protected function validator(array $data)
    {
        return Validator::make($data, array_merge([
            'title' => ['required', 'string'],
            'releaseDate' => ['required', 'date'],
            'description' => ['required', 'string'],
            'trailerLink' => ['required', 'string', 'starts_with:https://www.youtube.com/watch?v=', 'max:43','regex:/[A-Za-z0-9]{11}$/'],
            'soundtrackLink' => ['required', 'string', 'regex:/https:\/\/open\.spotify\.com\/album\/[A-Za-z0-9]{22}\?si=[A-Za-z0-9_-]+$/'],
            'artists' => ['array', 'min:1', 'exists:artists,id'],
            'poster' => ['image', 'required', 'mimes:jpeg,png,jpg', 'mimetypes:image/jpeg,image/png,image/jpg','max: 16777215',$this->checkImage()],
            'images' => ['required'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg', 'mimetypes:image/jpeg,image/png,image/jpg','max: 16777215', $this->checkImage()],
        ]));
    }

    public function resizeImage($image, $width)
    {
        $resizedImage = Image::make($image)->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $imageData = $resizedImage->encode(null)->getEncoded();

        return $imageData;
    }

    public function isDuplicateForAdd($movie)
    {
        $duplicate = Movie::where(['title'=> $movie->title])->where(['release_date' => $movie->releaseDate])->get();
        if(sizeof($duplicate)>0)
        {
            return true;
        }
        return false;
    }

    public function addMovie(Request $request)
    {
        $this->middleware('auth');
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $isDuplicate = $this->isDuplicateForAdd($request);
        if(!$isDuplicate) {
            $userId = auth()->user()->id;
            $p = $this->resizeImage($request->poster,300);
            $t = $this->changeTrailerLink($request->trailerLink);
            $s = $this->changeSoundtrackLink($request->soundtrackLink);

            $movie = Movie::create([
                'title' => $request->title,
                'release_date' => $request->releaseDate,
                'description' => $request->description,
                'trailer_link' => $t,
                'soundtrack_link' => $s,
                'poster' => $p,
                'user_id' => $userId,
                'status' => 'pending',
            ]);

            if (!empty($request->images)) {
                foreach ($request->images as $image) {
                    $i = $this->resizeImage($image, 600);
                    $movie->image()->create([
                        'image' => $i,
                    ]);
                }
            }

            $movie->artist()->sync($request->artists);
            return redirect('/movies')->with('success', 'Film was added successfully');
        }
        else
        {
            return redirect('/movies')->with('error', 'Film already exist in database');
        }

    }
    public function showMovie($id)
    {
        $userRate = null;
        if(auth()->user() != null)
        {
            $user_id = auth()->user()->id;
            $userRate = Rate::where('user_id', $user_id)->where('movie_id', $id)->first();
        }
        $movie = Movie::find($id);
        $movie->release_date = Carbon::parse($movie->release_date)->format('d.m.Y');
        $avgRate = $this->avgMovie($id);
        return view("showMovie", compact("movie","userRate","avgRate"));
    }

    public function deleteMovie($id)
    {
        $toDelete = Movie::find($id);
        if($toDelete)
        {
            $toDelete->delete();
            return redirect()->route('showMovies')->with('success', 'Your movie was delete');
        }
        else
        {
            return redirect()->route('showMovies')->with('error', "Movie with this ID doesn't exist!");

        }
    }
    public function editMovieForm($id)
    {
        $movie = Movie::find($id);
        $artist = Artist::all();
        return view("editMovie", compact("movie","artist"));
    }

    protected function validatorForEdit(array $data)
    {
        return Validator::make($data, array_merge([
            'title' => ['required', 'string'],
            'releaseDate' => ['required', 'date'],
            'description' => ['required', 'string'],
            'trailerLink' => ['required', 'string', 'max:255', 'regex:/^(?:https?:\/\/)?(?:www\.)?(?:youtube\.com\/(?:[^\/\n\s]+\/\S+\/|(?:v|e(?:mbed)?)\/|\S*?[?&]v=))([a-zA-Z0-9_-]{11})\b/'],
            'soundtrackLink' => ['required', 'string', 'max:255', 'regex:/^https:\/\/open\.spotify\.com\/album\/[a-zA-Z0-9]{22}(\?si=[A-Za-z0-9_-]+)?$/'],
            'artists' => ['array', 'min:1', 'exists:artists,id'],
            'poster' => ['image', 'mimes:jpeg,png,jpg', 'mimetypes:image/jpeg,image/png,image/jpg','max: 16777215',$this->checkImage()],
            'images.*' => ['image', 'mimes:jpeg,png,jpg', 'mimetypes:image/jpeg,image/png,image/jpg','max: 16777215',$this->checkImage()],
            'imagesToDelete' => ['array', function ($attribute, $value, $fail) use ($data) {
                if (count($value) === count($data['images']) && empty($data['images'])) {
                    $fail("Movie must have minimum one image");
                }
            }]
        ]));
    }
    public function editMovie(Request $request,$id)
    {
        $edit = Movie::find($id);
        if($request->poster==null)
        {
               $request->poster = $edit->poster;
        }

        if ($request->imagesToDelete != null)
        {
            $imagesToDelete = $request->input('imagesToDelete');
            $edit->image()->whereIn('id', $imagesToDelete)->delete();
        }
        $t = $this->changeTrailerLink($request->trailerLink);
        $s = $this->changeSoundtrackLink($request->soundtrackLink);
        $request->trailer_link = $t;
        $request->soundtrackLink = $s;

        $validator = $this->validatorForEdit($request->all());
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $p = $this->resizeImage($request->poster,300);

        $edit->update([
            'title' => $request->title,
            'release_date' => $request->releaseDate,
            'description' => $request->description,
            'trailer_link' => $t,
            'soundtrack_link' => $s,
            'poster' => $p,
            'status' => 'pending',
        ]);
        if (!empty($request->images)) {
            foreach ($request->images as $image) {
                $i = $this->resizeImage($image,600);
                $edit->image()->create([
                    'image' => $i,
                ]);
            }
        }
        if(auth()->user()->role=='admin')
        {
            return redirect()->route('showAdminPanel')->with('success', 'Movie was successfully updated');
        }
        return redirect()->route('showMovie',['id'=>$id])->with('success', 'Your movie was successfully updated');
    }

    public function avgMovie($id)
    {
        return Rate::where('movie_id', $id)->avg('rate');
    }

    protected function validatorCollection(array $data)
    {
        return Validator::make($data, array_merge([
            'name' => ['in:favorite,toWatch']
        ]));
    }

    public function addToCollection(Request $request)
    {
        $user = auth()->user();

        if ($user != null) {
            $movie = Movie::find($request->id);

            if ($movie != null) {
                $existingRecord = Collection::where([
                    'movie_id' => $request->id,
                    'user_id' => $user->id,
                    'name' => $request->name,
                ])->first();

                if ($existingRecord) {
                    return redirect()->route('showMovies')->with('error', 'This collection entry already exists');
                }

                $validator = $this->validatorCollection($request->all());
                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }

                $collection = Collection::create([
                    'user_id' => $user->id,
                    'movie_id' => $request->id,
                    'name' => $request->name,
                ]);

                if (!$collection) {
                    return redirect()->route('showMovies')->with('error', 'Something went wrong, try again');
                }
                return redirect()->route('showMovies')->with('success', 'Movie was add to collection');
            }
        }

        return redirect()->route('showMovies')->with('error', 'You are not logged in');
    }
    public function deleteFromCollection(Request $request)
    {
        $user_id = auth()->user()->id;
        $toDelete = Collection::where(['user_id' => $user_id])->where(['name'=>$request->name])->where(['movie_id' => $request->id]);
        if($toDelete)
        {
            $toDelete->delete();
            return redirect()->route('showMovies')->with('success', "Movie from you collection ".$request->name." was delete");
        }
        else
        {
            return redirect()->route('showMovies')->with('error', "Something was wrong");

        }
    }

}

