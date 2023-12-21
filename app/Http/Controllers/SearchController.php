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

    public function searchReturnJson($string)
    {
        try {
            $movies = Movie::where('title','like', '%' . $string . '%')->get();
            $artists = Artist::where('name', 'like', '%' . $string . '%')
                ->orWhere('surname', 'like', '%' . $string . '%')
                ->get();

            $movies->transform(function ($item) {
                $item['poster'] = base64_encode($item['poster']);
                return $item;
            });
            $artists->transform(function ($item) {
                $item['image'] = base64_encode($item['image']);
                return $item;
            });

            $result = $movies->merge($artists);

            return response()->json($result);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    }
}
