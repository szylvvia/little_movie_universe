<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Quiz;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Date;

class HomeController extends Controller
{
    public function index()
    {
        $currentDate = new DateTime();
        $currentDate = $currentDate->format('Y-m-d');

        $quiz = Quiz::where('start_date', '<=', $currentDate)
            ->whereDate('end_date', '>=', $currentDate)
            ->first();

        $votes = $quiz->answer()->count();
        $statMap = [];

        foreach ($quiz->question()->get() as $q)
        {
            $answer = $q->answer()->count();
            $stat = ($answer/$votes)*100;
            $statMap[$q->id] = $stat;
        }

        $isUserVoted = null;
        if(auth()->user())
        {
            if(auth()->user()->id)
            {
                $isUserVoted = Answer::where(['user_id'=>auth()->user()->id])->first();
            }
        }
        return view('home',compact('quiz', 'isUserVoted','statMap'));
    }
}
