<?php

namespace App\Http\Controllers;

use App\Models\Movie;
use Illuminate\Http\File;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Artist;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ArtistController extends Controller
{
    public function showArtists()
    {
        $artist = Artist::where('status', 'verified')->get();
        return view('artists', compact('artist'));
    }

    public function addArtistForm()
    {
        return view("addArtist");
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:50'],
            'surname' => ['required', 'string', 'max:50'],
            'birth_date' => ['required', 'date', 'before:today'],
            'death_date' => ['nullable', 'date', 'before:today'],
            'description' => ['nullable', 'string'],
            'profession' => ['required', 'in:Aktor,Reżyser,Scenarzysta,Kompozytor,Producent'],
            'gender' => ['required', 'in:Kobieta,Mężczyzna'],
            'image' => ['image', 'mimes:jpeg,png,jpg', 'mimetypes:image/jpeg,image/png,image/jpg', function ($attribute, $value, $fail) {
                $allowedExtensions = ['jpeg', 'png', 'jpg'];
                $extension = pathinfo($value->getClientOriginalName(), PATHINFO_EXTENSION);

                if ($extension === 'bin' || !in_array($extension, $allowedExtensions)) {
                    $fail("The $attribute must be a file of type: " . implode(', ', $allowedExtensions));
                }
            }],
        ]);
    }
    protected function validatorImageRequire(array $data)
    {
        return Validator::make($data, [
            'image' => ['required']
        ]);
    }

    public function resizeImage($image)
    {
        $resizedImage = Image::make($image)->resize(200, 100, function ($constraint) {
            $constraint->aspectRatio();
        });

        $imageData = $resizedImage->encode(null)->getEncoded();

        return $imageData;
    }

    public function addArtist(Request $request)
    {
        $this->middleware('auth');

        $imageValidator = $this->validatorImageRequire($request->all());
        $validator = $this->validator($request->all());

        if ($validator->fails() || $imageValidator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withErrors($imageValidator)
                ->withInput();
        }

        $userId = auth()->user()->id;
        $resizedImage = $this->resizeImage($request->image);

        Artist::create([
            'name' => $request->name,
            'surname' => $request->surname,
            'birth_date' => $request->birth_date,
            'death_date' => $request->death_date,
            'description' => $request->description,
            'user_id' => $userId,
            'status' => 'pending',
            'gender' => $request->gender,
            'profession' => $request->profession,
            'image' => $resizedImage
        ]);
        if(auth()->user()->role=='admin')
        {
            return redirect()->route('showAdminPanel')->with('success', 'Artist was successfully updated');
        }
        return redirect('/artists')->with('success', 'Artist was added successfully');
    }

    public function deleteArtist($id)
    {
        $this->middleware('auth');

        $toDelete = Artist::find($id);
        if($toDelete->user_id==auth()->user()->id or auth()->user()->role=='admin')
        {
            if($toDelete)
            {
                $toDelete->delete();
                return redirect()->route('showArtists')->with('success', 'Your artist was delete');
            }
            else
            {
                return redirect()->route('showArtist')->with('error', "Artist with this ID doesn't exist!");

            }
        }
        else
        {
            return redirect()->route('showArtist')->with('error', "This artist do not belong to you!");
        }

    }
    public function editArtistForm($id)
    {
        $this->middleware('auth');
        $artist = Artist::find($id);
        if($artist->user_id==auth()->user()->id or auth()->user()->role=='admin')
        {
            return view('editArtistForm', compact('artist'));
        }
        else
        {
            return redirect()->route('showArtist', ['id' => $artist->id])->with('error', "This artist does not belong to you!");
        }

    }

    public function editArtist(Request $request, $id)
    {
        $this->middleware('auth');
        $edit = Artist::find($id);
        if($edit->user_id==auth()->user()->id or auth()->user()->role=='admin')
        {
            if($request->image==null)
            {
                $request->image = $edit->image;
            }
            else
            {
                $request->image = $this->resizeImage($request->image);
            }

            $validator = $this->validator($request->all());

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $edit->update([
                'name' => $request->name,
                'surname' => $request->surname,
                'birth_date' => $request->birth_date,
                'death_date' => $request->death_date,
                'description' => $request->description,
                'status' => 'pending',
                'gender' => $request->gender,
                'profession' => $request->profession,
                'image' => $request->image
            ]);

            if(auth()->user()->role=='admin')
            {
                return redirect()->route('showAdminPanel')->with('success', 'Artist was successfully updated');
            }
            return redirect()->route('showArtist',['id'=>$id])->with('success', 'Your artist was successfully updated');
        }
        else
        {
            return redirect()->route('showArtists')->with('error', 'Artist do not belong to you');
        }
    }

    public function showArtist($id)
    {
        $artist = Artist::find($id);
        $artist->birth_date = Carbon::parse($artist->birth_date)->format('d.m.Y');
        if($artist->death_date!=null)
        {
            $artist->death_date = Carbon::parse($artist->death_date)->format('d.m.Y');
        }
        return view("showArtist", compact("artist"));
    }

}
