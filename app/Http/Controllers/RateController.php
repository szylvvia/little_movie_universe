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
        $data['rate'] = intval($data['rate']);
        return Validator::make($data, array_merge([
            'rate' => ['required', 'numeric', 'max:10', 'min:1'],
            'review' => ['nullable','string', 'max:255']
        ]));
    }

    public function addOrEditRate($id,Request $request)
    {
        $validator = $this->validator($request->all());

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }
        $user_id = auth()->user()->id;
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
                return redirect()->route('showMovie',['id'=>$id])->with('success', 'Ocena i recenzja została dodana pomyślnie.');
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
            $result = $existingRate->delete();
            if($result)
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
