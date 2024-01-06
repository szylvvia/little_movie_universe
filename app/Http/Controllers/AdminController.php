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
        return redirect()->route('home')->with('error', 'Dostęp tylko dla administatora');
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

                    if($request->decision=='verified')
                    {
                        return redirect()->route('showAdminPanel')->with('success', 'Film został pomyślnie zaakceptowany.');
                    }
                    else
                    {
                        return redirect()->route('showAdminPanel')->with('success', 'Film został odrzucony.');
                    }

                }
                return redirect()->route('showAdminPanel')->with('error', 'Coś poszło nie tak. Spróbuj ponownie póżniej.');
            }
            return redirect()->route('showAdminPanel')->with('error', 'Dostęp tylko dla administratora');
        }
        return redirect()->route('showAdminPanel')->with('error', 'Dostęp tylko dla zalogowanych');
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

                    if($request->decision=='verified')
                    {
                        return redirect()->route('showAdminPanel')->with('success', 'Artysta został pomyślnie zaakceptowany.');
                    }
                    else
                    {
                        return redirect()->route('showAdminPanel')->with('success', 'Artysta został odrzucony.');
                    }
                }return redirect()->route('showAdminPanel')->with('error', 'Coś poszło nie tak. Spóbuj ponownie później!');
            }return redirect()->route('showAdminPanel')->with('error', 'Dostęp tylko dla administratora.');
        }return redirect()->route('showAdminPanel')->with('error', 'Nie jesteś zalogowany!');
    }
}

