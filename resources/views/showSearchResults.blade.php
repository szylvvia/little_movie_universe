@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Result for <i><b>{{$string}}</b></i></h1>
        <hr>
        <h3>Movies</h3>
        <div class="row">
            @if(sizeof($movies)==0)
                <p>No results</p>
            @else
                @foreach($movies as $m)
                    <div class="row mb-5 mt-3">
                        <div class="col-md-2">
                            <img src="data:image/jpeg;base64,{{ base64_encode($m->poster) }}" alt="Opis obrazu" class="poster-small">
                            <div class="md-2 mx-2 mt-2"><a href="{{ route('showMovie', ['id' => $m->id]) }}" class="text-decoration-none title-movie"><h5>{{$m->title}}</h5></a></div>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>

        <h3>Artists</h3>
        <div class="row">
            @if(sizeof($artists)==0)
                <p><i>No results</i></p>
            @else
                @foreach($artists as $a)
                    <p>{{$a->name}} {{$a->surname}}</p>
                @endforeach
            @endif
        </div>
    </div>
@endsection
