@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card-body">
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
                <div class="row mb-3">
                    <div class="col-md-10 d-flex align-items-center">
                        <h1>All Artists</h1>
                        @auth
                            <a href="{{ route('addArtistForm') }}" class="ms-3" title="Add new artist"><h3><i class="bi bi-plus-circle icon-color"></i></h3></a>
                        @endauth
                    </div>
                </div>
            <div class="row">
                @foreach($artist as $a)
                    <div class="col-md-4 mb-4 text-center">
                        <div class="row">
                            <a href="{{ route('showArtist', ['id' => $a->id]) }}" class="text-decoration-none">
                                <div class="col-md-12">
                                    @if($a->image != null)
                                        <img class="quiz-image" src="data:image/jpeg;base64,{{ base64_encode($a->image) }}" alt="Opis obrazu">
                                    @endif
                                </div>
                                <div class="col-md-12 mt-3 custom-text">
                                    <h3>{{$a->name}} {{$a->surname}}</h3>
                                </div>
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
@endsection
