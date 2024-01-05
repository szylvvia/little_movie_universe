@extends('layouts.app')

@section('content')
    <div class="container">
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
            <div class="row mb-3">
               <div class="col-md-10 d-flex align-items-center">
                   <h1>Ranking filmów na bazie ocen użytkowników</h1>
                   @auth
                       <a href="{{ route('addMovieForm') }}" class="ms-3 mt-2" title="Add new movie"><h3><i class="bi bi-plus-circle icon-color"></i></h3></a>
                   @endauth
               </div>
            </div>

            <?php $counter = 0; ?>
            @foreach($movies as $key => $m)
                <div class="row mb-5">
                    <div class="col-md-2">
                        <a href="{{ route('showMovie', ['id' => $m->id]) }}" class="text-decoration-none title-movie">
                            <img src="data:image/jpeg;base64,{{ base64_encode($m->poster) }}" alt="Opis obrazu" class="poster-small quiz-image">
                        </a>
                    </div>
                    <div class="col-md-5">
                        <div class="mb-3">
                            <a href="{{ route('showMovie', ['id' => $m->id]) }}" class="text-decoration-none title-movie"><h3>{{$m->title}}</h3></a>
                        </div>
                        <div class="mb-3">
                            <h5>{{$m->description}}</h5>
                        </div>
                        <div class="mb-3">
                            <p>{{$m->release_date}}</p>
                        </div>
                        <div class="mb-2">
                            <img src="{{asset('img/Gold_Star.png')}}" alt="star" class="little-star">
                            <span class="ml-2">{{number_format($m->avg,1)}}</span>
                        </div>
                        <div class="mb-2 col-md-1">
                            @auth
                                <div class="d-flex justify-content-between">
                                    @if(!$m->isFav)
                                        <form method="POST" action="{{ route('addToCollection', ['id' => $m->id,'name' => 'favorite']) }}">
                                            @csrf
                                            <button type="submit" class="btn" title="Dodaj do ulubionych"><h4><i class="bi bi-heart movie-fav"></i></h4></button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('deleteFromCollection', ['id' => $m->id,'name' => 'favorite']) }}">
                                            @csrf
                                            <button type="submit" class="btn" title="Usuń z ulubionych"><h4><i class="bi bi-heart-fill movie-fav"></i></h4></button>
                                        </form>
                                    @endif

                                    @if(!$m->isWatch)
                                        <form method="POST" action="{{ route('addToCollection', ['id' => $m->id,'name' => 'toWatch']) }}">
                                            @csrf
                                            <button type="submit" class="btn" title="Dodaj do obejrzenia"><h4><i class="bi bi-stopwatch movie-watch"></i></h4></button>
                                        </form>
                                    @else
                                        <form method="POST" action="{{ route('deleteFromCollection', ['id' => $m->id,'name' => 'toWatch']) }}">
                                            @csrf
                                            <button type="submit" class="btn" title="Usuń z do obejrzenia"><h4><i class="bi bi-stopwatch-fill movie-watch"></i></h4></button>
                                        </form>
                                    @endif
                                </div>
                            @endauth
                        </div>
                    </div>
                    <div class="col-md-1 offset-md-3 text-right custom-place">
                        <p class="moviePlaceNumber ms-5">{{ ++$counter }}</p>
                        <p class="moviePlaceText ms-3">place</p>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
@endsection
