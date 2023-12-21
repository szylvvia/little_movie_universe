<?php

namespace App\Http\Controllers;

use App\Models\Answer;
use App\Models\Movie;
use App\Models\Question;
use App\Models\Quiz;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Intervention\Image\Facades\Image;
use function PHPUnit\Framework\isNull;

class QuizController extends Controller
{
    public function addQuizForm()
    {
        $user = auth()->user();
        $role = $user->role;

        if($user and $role=='admin')
        {
            return view("addQuizForm");
        }
        return view("home");
    }
    protected function checkImage()
    {
        return ['image', 'mimes:jpeg,png,jpg', 'mimetypes:image/jpeg,image/png,image/jpg', 'max: 16777215', function ($attribute, $value, $fail) {
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
        $rules = [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'images.*' => ['required','image', 'mimes:jpeg,png,jpg', 'mimetypes:image/jpeg,image/png,image/jpg','max: 16777215', $this->checkImage()],
            'questions.*' => ['required', 'string', "min:3",'max:100']
        ];

        return Validator::make($data, $rules);
    }

    protected function validateDateAvailability($validator, $start, $end)
    {
        $quizzes = Quiz::where(function ($query) use ($start, $end) {
            $query->where('start_date', '<', $end)
                ->where('end_date', '>', $start);
        })->get();

        if (sizeof($quizzes) > 0) {
            $validator->errors()->add('start_date', 'Data is already taken');
            $validator->errors()->add('end_date', 'Data is already taken');
        }
    }

    public function resizeImage($image, $width)
    {
        $resizedImage = Image::make($image)->resize($width, null, function ($constraint) {
            $constraint->aspectRatio();
        });

        $imageData = $resizedImage->encode(null)->getEncoded();

        return $imageData;
    }
    public function addQuiz(Request $request)
    {
        $user = auth()->user()->id;

        if(auth()->user()->id)
        {
            if(auth()->user()->role=='admin') {
                $validator = $this->validator($request->all());

                $validator->after(function ($validator) use ($request) {
                    $this->validateDateAvailability($validator, $request->start_date, $request->end_date);
                });

                if ($validator->fails()) {
                    return redirect()->back()
                        ->withErrors($validator)
                        ->withInput();
                }

                $quiz = Quiz::create(
                    [
                        'title' => $request->title,
                        'description' => $request->description,
                        'start_date' => $request->start_date,
                        'end_date' => $request->end_date,
                        'user_id' => $user
                    ]
                );
                $quiz->save();

                for ($i = 1; $i <= 3; $i++) {
                    $image = $request->file("images.$i");

                    $resizedImage = $this->resizeImage($image, 200);
                    $quiz->question()->create([
                        'question' => $request->input("options.$i"),
                        'image' => $resizedImage,
                    ]);
                }
            }
            else
            {
                return redirect()->route("home")->with('error','You are not admin, create quiz is not allowed');
            }
        }
        return redirect()->route("showAdminPanel")->with('success','Quiz was create succesfuly');
    }

    public function addAnswer(Request $request)
    {
        $currentDate = new DateTime();
        $currentDate = $currentDate->format('Y-m-d');

        $quiz = Quiz::where('start_date', '<=', $currentDate)
            ->whereDate('end_date', '>=', $currentDate)
            ->first();

        $currentAnswer = Answer::where(['quiz_id'=>$quiz->id, 'user_id'=>auth()->user()->id,'question_id' => $request->question_id])->first();
        if(isNull($currentAnswer)) {
            if ($quiz->id == $request->quiz_id) {
                $question = Question::where(['id' => $request->question_id])->first();
                if ($question != null) {
                    $answer = Answer::create(
                        [
                            'user_id' => auth()->user()->id,
                            'question_id' => $request->question_id,
                            'quiz_id' => $request->quiz_id,
                        ]
                    );
                    if ($answer) {
                        return redirect()->route("home")->with('success', 'Vote was successfully added');
                    }
                }
            }
        }
        else
        {
            return redirect()->route("home")->with('error', 'You already add vote to this quiz');
        }
        return redirect()->route("home")->with('error','Something gone wrong. Try again');
    }

    public function deleteAnswer(Request $request)
    {
        $this->middleware('auth');
        $user_id = auth()->user()->id;

        $toDelete = Answer::where(['user_id' => $user_id])->where(['quiz_id' => $request->quiz_id])->where(['question_id'=>$request->question_id]);

        if($toDelete)
        {
            $toDelete->delete();
            return redirect()->route('home')->with('success', 'Your vote was delete');
        }
        else
        {
            return redirect()->route('home')->with('error', "Vote doesn't exist!");

        }

    }


    public function deleteQuiz($id)
    {
        $toDelete = Quiz::find($id);
        if($toDelete)
        {
            $toDelete->delete();
            return redirect()->route('showAdminPanel')->with('success', 'Your quiz was delete');
        }
        else
        {
            return redirect()->route('showAdminPanel')->with('error', "Movie with this ID doesn't exist!");

        }
    }

    public function editQuizForm($id)
    {
        $this->middleware('auth');

        $quiz = Quiz::where(['id'=>$id])->first();
        if($quiz)
        {
            if(auth()->user()->id == $quiz->user_id )
            {
                return view('editQuiz',compact('quiz'));
            }
            else
            {
                return redirect()->route('showAdminPanel')->with('error', "Quiz is not yours");
            }
        }
        else
        {
            return redirect()->route('showAdminPanel')->with('error', "Quiz with this ID does not exist");
        }
    }

    protected function validatorForEdit(array $data)
    {
        $rules = [
            'title' => ['required', 'string'],
            'description' => ['required', 'string'],
            'start_date' => ['required', 'date', 'after_or_equal:today'],
            'end_date' => ['required', 'date', 'after:start_date'],
            'images.*' => ['image', 'mimes:jpeg,png,jpg', 'mimetypes:image/jpeg,image/png,image/jpg','max: 16777215', $this->checkImage()],
            'questions.*' => ['required', 'string', "min:3",'max:100']
        ];

        return Validator::make($data, $rules);
    }
    protected function validateDateAvailabilityForEdit($validator, $start, $end, $id)
    {
        $quizzes = Quiz::where(function ($query) use ($start, $end) {
            $query->where('start_date', '<', $end)
                ->where('end_date', '>', $start);
        })->get();

        if (sizeof($quizzes) > 0) {
            foreach ($quizzes as $q)
            {
                if($q->id != $id)
                {
                    $validator->errors()->add('start_date', 'Data is already taken');
                    $validator->errors()->add('end_date', 'Data is already taken');
                }
            }

        }
    }
    public function editQuiz(Request $request, $id)
    {
        $this->middleware('auth');
        $user = auth()->user()->id;

        $quiz = Quiz::find($id);

        if ($quiz->user_id == $user) {
            $validator = $this->validatorForEdit($request->all());

            $validator->after(function ($validator) use ($request, $id) {
                $this->validateDateAvailabilityForEdit($validator, $request->start_date, $request->end_date, $id);
            });

            if ($validator->fails()) {
                return redirect()->back()
                    ->withErrors($validator)
                    ->withInput();
            }

            $questions = Question::where(['quiz_id' => $quiz->id])->get();

            foreach ($questions as $q) {
                $imageFieldName = "images.{$q->id}";

                if (!$request->hasFile($imageFieldName)) {
                    $request->merge([$imageFieldName => $q->image]);
                }
            }

            $quiz->update([
                'title' => $request->title,
                'description' => $request->description,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            foreach ($questions as $q) {
                $imageFieldName = "images.{$q->id}";

                if ($request->hasFile($imageFieldName)) {
                    $image = $this->resizeImage($request->file($imageFieldName), 200);
                }
                else
                {
                    $image = $q->image;
                }

                $quiz->question()->where('id', $q->id)->update([
                    'question' => $request->input("questions.{$q->id}"),
                    'image' => $image,
                ]);
            }
        }

        return redirect()->route('showAdminPanel')->with('success', 'Your quiz updated successfully');
    }
}
