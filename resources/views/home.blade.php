@extends('layouts.app')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            @if (session('status'))
                <div class="alert alert-success" role="alert">
                    {{ session('status') }}
                </div>
            @endif
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
               <div class="alert alert-danger" role="alert">
                   {{ session('error') }}
               </div>
            @endif
        </div>
    </div>
    <div class="row justify-content-center">
        <div class="col-md-6 text-center">
            <h1>{{$quiz->title}}</h1>
            <h5>{{$quiz->description}}</h5>
        </div>
    </div>
    <div class="row mt-3 justify-content-center">
        @guest
            @foreach($quiz->question as $q)
                <div class="col-md-3 mt-3 text-center">
                    <img src="data:image/jpeg;base64,{{ base64_encode($q->image) }}" alt="Opis obrazu">
                    <h5 class="mt-2">{{$q->question}}</h5>
                    <p>{{ number_format($statMap[$q->id], 1, '.', '') ?? '0' }}%</p>
                </div>
            @endforeach
        @endguest
        @auth
            @if($isUserVoted)
               @foreach($quiz->question as $q)
                   @if($q->id==$isUserVoted->question_id)
                       <div class="col-md-3 mt-3 text-center">
                           <img src="data:image/jpeg;base64,{{ base64_encode($q->image) }}" alt="Opis obrazu">
                           <form method="POST" action="{{ route('deleteAnswer', ['question_id'=>$q->id, 'quiz_id'=>$quiz->id]) }}">
                               @csrf
                               <button type="submit" class="btn">
                                   <h5 class="mt-2"><i class="bi bi-bookmark-star-fill"></i>{{$q->question}}</h5>
                                    <p>{{ number_format($statMap[$q->id], 1, '.', '') ?? '0' }}%</p>
                               </button>
                           </form>
                       </div>
                        @else
                            <div class="col-md-3 mt-3 text-center">
                                <img src="data:image/jpeg;base64,{{ base64_encode($q->image) }}" alt="Opis obrazu">
                                <h5 class="mt-2">{{$q->question}}</h5>
                                <p>{{ number_format($statMap[$q->id], 1, '.', '') ?? '0' }}%</p>
                            </div>
                      @endif
                @endforeach
            @else
                @foreach($quiz->question as $q)
                    <div class="col-md-3 mt-3 text-center">
                        <form method="POST" action="{{ route('addAnswer', ['question_id'=>$q->id, 'quiz_id'=>$quiz->id]) }}">
                            @csrf
                            <button type="submit" class="btn">
                                <img src="data:image/jpeg;base64,{{ base64_encode($q->image) }}" alt="Opis obrazu">
                                <h5>{{$q->question}}</h5>
                            </button>
                        </form>
                    </div>
                @endforeach
            @endif
        @endauth
    </div>

</div>
@endsection
