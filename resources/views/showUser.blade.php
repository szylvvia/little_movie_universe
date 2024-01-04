@extends('layouts.app')

@section('content')
    <div class="container">
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
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteModalLabel">Delete</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Are you sure you want to delete your profile <strong>{{$user->name}} {{$user->surname}}</strong>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                            <form method="POST" action="{{ route('deleteUser') }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Delete account</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
                <div class="row mb-3 align-content-center">
                    <img src="data:image/jpeg;base64,{{ base64_encode($user->background) }}" alt="User background" class="user-background">
                </div>
                <div class="d-flex flex-column align-items-center">
                    <div>
                        <img src="{{$user->image}}" alt="User image" class="rounded-circle user-image-medium">
                    </div>
                    <div class="col-md-9">
                        <div class="d-flex align-items-center justify-content-center flex-column">
                            <h3>{{$user->name}} {{$user->surname}}</h3>
                            @auth()
                                @if($user->id==auth()->user()->id)
                                    <div class="d-flex justify-content-center">
                                        <a href="{{ route('editUserForm')}}" class="btn me-2" title="editProfile"><h5><i class="bi bi-gear"></i></h5></a>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" title="Delete profile"><h5><i class="bi bi-x-circle"></i></h5></button>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                    @if($user->desccription)
                    <div class="align-content-center text-center">
                        <p><i>{{$user->description}}</i></p>
                    </div>
                    @endif

                </div>
            <hr>
            <div class="row mb-3"></div>
                <div class="col-auto">
                    <div class="row mb-3">
                        <h4>Favorite</h4>
                        @if($fav->isNotEmpty())
                            @foreach($fav as $f)
                                <div class="col-md-1 text-center">
                                    <div class="d-flex flex-column align-items-center">
                                        <a href="{{ route('showMovie', ['id' => $f->movie->id]) }}" class="text-decoration-none">
                                            <img src="data:image/jpeg;base64,{{ base64_encode($f->movie->poster) }}" class="imageArtistMini" alt="Opis obrazu">
                                            <p>{{$f->movie->title}}</p>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p><i>No favorite movies. Let's add something!</i></p>
                        @endif
                    </div>
                    <div class="row mb-3">
                        <h4>To watch</h4>
                        @if($wat->isNotEmpty())
                            @foreach($wat as $w)
                                <div class="col-md-1 text-center">
                                    <div class="d-flex flex-column align-items-center">
                                        <a href="{{ route('showMovie', ['id' => $w->movie->id]) }}" class="text-decoration-none">
                                            <img src="data:image/jpeg;base64,{{ base64_encode($w->movie->poster) }}" class="imageArtistMini" alt="Opis obrazu">
                                            <p>{{$w->movie->title}}</p>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p><i>No movies to watch. Let's add something!</i></p>
                        @endif
                    </div>
                </div>
        @guest
        @endguest
    </div>
@endsection
