@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <h1>All Artists</h1>
           @auth
               <a href="{{ route('addArtistForm') }}">Add artist</a>
           @endauth
            <hr>
            <div class="row">
                @foreach($artist as $a)
                    <div class="col-md-4 mb-4 text-center">
                        <div class="row">
                            <div class="col-md-12">
                                @if($a->image != null)
                                    <img src="data:image/jpeg;base64,{{ base64_encode($a->image) }}" alt="Opis obrazu">
                                @endif
                            </div>
                            <div class="col-md-12 mt-3">
                                <a href="{{ route('showArtist', ['id' => $a->id]) }}" class="text-decoration-none">
                                    <h3>{{$a->name}} {{$a->surname}}</h3>
                                </a>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
