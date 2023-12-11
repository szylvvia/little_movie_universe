<?php

namespace App\Http\Controllers;

use App\Models\Artist;
use App\Models\Movie;
use Illuminate\Http\Request;

class SearchController extends Controller
{
    public function search($string)
    {
        $movies = Movie::where('title','like', '%' . $string . '%')->get();
        $artists = Artist::where('name', 'like', '%' . $string . '%')
            ->orWhere('surname', 'like', '%' . $string . '%')
            ->get();

        return view('showSearchResults', compact('movies', 'artists', 'string'));

    }
}
