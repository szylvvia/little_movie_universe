<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Movie;
use App\Models\Quiz;
use Database\Seeders\ArtistSeeder;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    public function showAdminPanel()
    {
        if (auth()->user()) {
            if (auth()->user()->role == 'admin') {
                $pendingMovies = Movie::where('status', 'pending')->get();
                $pendingArtist = Artist::where('status', 'pending')->get();
                $quizzes = Quiz::where(['user_id'=>auth()->user()->id])->get();

                return view('adminPanel', compact('pendingMovies', 'pendingArtist','quizzes'));
            }
        }
        return redirect()->route('home')->with('error', 'You are not admin');
    }

    protected function validatorVerify(array $data)
    {
        return Validator::make($data, array_merge([
            'name' => ['in:verified,rejected']
        ]));
    }

    public function verifyMovie(Request $request)
    {
        if (auth()->user()) {
            if (auth()->user()->role == 'admin') {
                $movieToAccept = Movie::find($request->id);
                if ($movieToAccept) {
                    $validator = $this->validatorVerify($request->all());
                    if ($validator->fails()) {
                        return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
                    }
                    $movieToAccept->update(['status' => $request->decision]);

                    return redirect()->route('showAdminPanel')->with('success', 'Movie successfully ' . $request->decision);
                }
                return redirect()->route('showAdminPanel')->with('error', 'Something gone wrong. Try again');
            }
            return redirect()->route('showAdminPanel')->with('error', 'You are not admin');
        }
        return redirect()->route('showAdminPanel')->with('error', 'You are not login');
    }

    public function verifyArtist(Request $request)
    {
        if(auth()->user())
        {
            if(auth()->user()->role=='admin')
            {
                $artistToAccept = Artist::find($request->id);
                if($artistToAccept)
                {
                    $validator = $this->validatorVerify($request->all());
                    if ($validator->fails()) {
                        return redirect()->back()
                            ->withErrors($validator)
                            ->withInput();
                    }

                    $artistToAccept->update(['status'=>$request->decision]);

                    return redirect()->route('showAdminPanel')->with('success', 'Artist was successfully '.$request->decision);
                }return redirect()->route('showAdminPanel')->with('error', 'Something gone wrong. Try again');
            }return redirect()->route('showAdminPanel')->with('error', 'You are not admin');
        }return redirect()->route('showAdminPanel')->with('error', 'You are not login');
    }
}

