<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use App\Http\Controllers\MovieController;

class RateController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');

    }
    protected function validator(array $data)
    {
        return Validator::make($data, array_merge([
            'rate' => ['required', 'min:1', 'max:10'],
            'review' => ['nullable','string', 'max:255',function ($attribute, $value, $fail) {
                $cleanedReview = strip_tags($value);
                if ($value !== $cleanedReview) {
                    $fail('Recenzja jest niepoprawna!');
                }
            }]

        ]));
    }

    public function addOrEditRate($id,Request $request)
    {
        $user_id = auth()->user()->id;

        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $existingRate = Rate::where('user_id', $user_id)->where('movie_id', $id)->first();

        if($existingRate==null)
        {
            $rate = Rate::create([
                'user_id' => $user_id,
                'movie_id' => $id,
                'rate' => $request->rate,
                'review' => trim($request->review)
            ]);
            if ($rate) {
                return redirect()->route('showMovie',['id'=>$id])->with('success', 'Ocena została zaktualizowana pomyślnie.');
            } else {
                return redirect()->route('showMovie',['id'=>$id])->with('error', 'Coś poszło nie tak. Spróbuj ponownie.');
            }
        }
        else
        {
            $rate = $existingRate->update([
                'rate' => $request->rate,
                'review' => trim($request->review)
            ]);
            if ($rate) {
                return redirect()->route('showMovie',['id'=>$id])->with('success', 'Ocena została zaktualizowana pomyslnie.');
            } else {
                return redirect()->route('showMovie',['id'=>$id])->with('error', 'Coś poszło nie tak. Spróbuj ponownie.');
            }
        }
    }

    public function deleteRate($id)
    {
        $existingRate = Rate::where('user_id', auth()->user()->id)->where('movie_id', $id)->first();
        if($existingRate)
        {
            $resoult = $existingRate->delete();
            if($resoult)
            {
                return redirect()->route('showMovie',['id'=>$id])->with('success', 'Ocena została zaktualizowana pomyślnie.');
            }
            else
            {
                return redirect()->route('showMovie',['id'=>$id])->with('error', 'Coś poszło nie tak. Spróbuj ponownie.');
            }
        }
        else
        {
            return redirect()->route('showMovie',['id'=>$id])->with('error', 'Ocena do tego filmu nie istenieje.');

        }
    }
}
