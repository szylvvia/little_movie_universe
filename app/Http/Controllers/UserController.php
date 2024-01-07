<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Collection;
use App\Models\Movie;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except('showUser');
    }

    public function getUserId()
    {
        if(auth()->user()==null)
        {
            return null;
        }
        return auth()->user()->id;
    }

    public function showUser($id)
    {
        $user = User::where(['id'=>$id])->get();
        if($user->isNotEmpty())
        {
            $user = User::find($id);
            $fav = Collection::where(['user_id'=>$id, 'name' => 'favorite'])->get();
            $wat = Collection::where(['user_id'=>$id, 'name' => 'toWatch'])->get();
            $pendingMovies = Movie::where(['user_id'=>$id, 'status'=>'pending'])->get();
            $pendingArtists = Artist::where(['user_id'=>$id, 'status'=>'pending'])->get();
            $rejectedMovies = Movie::where(['user_id'=>$id, 'status'=>'rejected'])->get();
            $rejectedArtists = Artist::where(['user_id'=>$id, 'status'=>'rejected'])->get();

            $pending = $pendingMovies->merge($pendingArtists);
            $rejected = $rejectedMovies->merge($rejectedArtists);

            return view("showUser", compact("user","fav","wat","pending","rejected"));
        }
        return redirect()->route('home')->with('error', 'Użytkownik nie istnieje');
    }

    public function deleteUser()
    {
        $id = $this->getUserId();
        $toDelete = User::find($id);
        if($toDelete)
        {
            $toDelete->delete();
            return redirect()->route('home')->with('success', 'Twoje konto zostało usunięte pomyślnie.');
        }
        return redirect()->route('home')->with('error', 'Użytkownik o wybranym ID nie istenieje.');
    }

    public function editUserForm()
    {
        $id = $this->getUserId();
        $user = User::find($id);
        return view("editUser", compact("user"));
    }

    protected function checkImage()
    {
        return ['image','max: 16777215', function ($attribute, $value, $fail) {
            $allowedExtensions = ['jpeg', 'png', 'jpg'];
            $extension = pathinfo($value->getClientOriginalName(), PATHINFO_EXTENSION);

            if ($extension === 'bin' || !in_array($extension, $allowedExtensions)) {
                $fail("Obraz musi być typu: " . implode(', ', $allowedExtensions));
            }

            if ($value->getSize() > 5242880) {
                $fail("Obraz nie może być większy niż 5 MB.");
            }
        }];
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:50','regex:/^[A-ZĄĆĘŁŃÓŚŹŻ][A-Za-ząćęłńóśźżĄĆĘŁŃÓŚŹŻ]+(\s[A-ZĄĆĘŁŃÓŚŹŻ][a-ząćęłńóśźżĄĆĘŁŃÓŚŹŻ]+)?$/u'],
            'surname' => ['required', 'string', 'max:50','regex:/^[A-ZĄĆĘŁŃÓŚŹŻ][A-Za-ząćęłńóśźżĄĆĘŁŃÓŚŹŻ]+(-[A-ZĄĆĘŁŃÓŚŹŻ][a-ząćęłńóśźżĄĆĘŁŃÓŚŹŻ]+)?$/u'],
            'birth_date' => ['required','date','before:today'],
            'description' => ['max:255'],
            'image' => ['mimes:jpeg,png,jpg', 'max:5242880',$this->checkImage()],
            'background' => ['mimes:jpeg,png,jpg', 'max:5242880',$this->checkImage()]
        ]);
    }
    public function resizeImage($image, $width)
    {
        $resizedImage = Image::make($image)->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        return $resizedImage->encode(null)->getEncoded();
    }
    public function editUser(Request $request)
    {
        $id = $this->getUserId();
        $user = User::find($id);

        $validator = $this->validator($request->all());
        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $image = $user->image;
        if ($request->hasFile('image')) {
            $image = $this->resizeImage($request->file('image'), 100);
        }

        $background = $user->background;
        if ($request->hasFile('background')) {
            $background = $this->resizeImage($request->file('background'), 1000);
        }

        if(!$request->description)
        {
            $request->description = $user->description;
        }

        $add = $user->update([
            'name' => $request -> name,
            'surname' => $request -> surname,
            'birth_date' => $request -> birth_date,
            'description' => $request -> description,
            'image' => $image,
            'background' => $background
            ]);

        if($add)
        {
            return redirect()->route('showUser')->with('success', 'Twój profil został pomyslnie zaktualizowany.');
        }
        else  return redirect()->route('showUser')->with('error', 'Coś poszło nie tak. Spróbuj ponownie później.');
    }

}
