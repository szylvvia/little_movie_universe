<?php

namespace App\Http\Controllers;

use App\Models\Collection;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;

class UserController extends Controller
{
    public function getUserId()
    {
        $this->middleware('auth');

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
            return view("showUser", compact("user","fav","wat"));
        }
        return redirect()->route('home')->with('error', 'User is not existing');
    }

    public function deleteUser()
    {
        $this->middleware('auth');

        $id = $this->getUserId();
        $toDelete = User::find($id);
        if($toDelete)
        {
            $toDelete->delete();
            return redirect()->route('home')->with('success', 'Your account was delete');
        }
        return redirect()->route('home')->with('error', 'User is not existing');
    }

    public function editUserForm()
    {
        $this->middleware('auth');

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
                $fail("The $attribute must be a file of type: " . implode(', ', $allowedExtensions));
            }

            if ($value->getSize() > 5242880) {
                $fail("The $attribute must not be larger than 5 MB.");
            }
        }];
    }
    protected function validator(array $data)
    {
        return Validator::make($data, [
            'name' => ['required', 'string', 'max:50','regex:/^[A-Za-ząćęłńóśźżĄĆĘŁŃÓŚŹŻ]+$/u'],
            'surname' => ['required', 'string', 'max:50','regex:/^[A-Za-ząćęłńóśźżĄĆĘŁŃÓŚŹŻ]+$/u'],
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
        $this->middleware('auth');
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
            return redirect()->route('showUser')->with('success', 'Your account was updated!');
        }
        else  return redirect()->route('showUser')->with('error', 'Something was wrong. Try again!');
    }

}
