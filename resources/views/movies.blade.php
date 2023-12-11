@extends('layouts.app')

@section('content')
    <div class="container" xmlns="http://www.w3.org/1999/html">
        <div class="card-body">
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
                @if($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            <h1>All Movies</h1>
                <hr>
            <div class="row mb-3">
                <div class="col-md-2">
                    @auth
                    <a href="{{ route('addMovieForm') }}" class="btn btn-secondary">Add movie</a>
                    @endauth
                </div>
            </div>
            @foreach($movies as $m)
                <div class="row mb-5">
                    <div class="col-md-2">
                        <img src="data:image/jpeg;base64,{{ base64_encode($m->poster) }}" alt="Opis obrazu" class="poster-small">
                    </div>
                    <div class="col-md-6">
                        <div class="mb-3">
                            <a href="{{ route('showMovie', ['id' => $m->id]) }}" class="text-decoration-none title-movie"><h3>{{$m->title}}</h3></a>
                        </div>
                        <div class="mb-2">
                            <img src="{{asset('img/Gold_Star.png')}}" alt="star" class="little-star">
                            <span class="ml-2">{{number_format($m->avg,1)}}</span>
                        </div>
                        <div class="mb-2">
                            @auth
                                @if(!$m->isFav)
                                    <form method="POST" action="{{ route('addToCollection', ['id' => $m->id,'name' => 'favorite']) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success">Favorite</button>
                                    </form>
                                @else
                                    <form method="POST" action="{{ route('deleteFromCollection', ['id' => $m->id,'name' => 'favorite']) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-success">Delete from favorite</button>
                                    </form>
                                @endif<br>
                                @if(!$m->isWatch)
                                    <form method="POST" action="{{ route('addToCollection', ['id' => $m->id,'name' => 'toWatch']) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-info">To watch</button>
                                    </form>
                                    @else
                                        <form method="POST" action="{{ route('addToCollection', ['id' => $m->id,'name' => 'favorite']) }}">
                                            @csrf
                                            <button type="submit" class="btn btn-info">Delete from to watch</button>
                                        </form>
                                @endif
                            @endauth
                        </div>

                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
