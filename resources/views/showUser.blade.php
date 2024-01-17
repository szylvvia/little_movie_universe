@extends('layouts.app')

@section('content')
    <div class="container">
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
            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                <div class="modal-dialog">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="confirmDeleteModalLabel">Usuń profil</h5>
                            <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                        </div>
                        <div class="modal-body">
                            Czy na pewno chcesz usunąć swój profil <strong>{{$user->name}} {{$user->surname}}</strong>?
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn add-button" data-bs-dismiss="modal">Anuluj</button>
                            <form method="POST" action="{{ route('deleteUser') }}">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">Usuń konto</button>
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
                                        <a href="{{ route('editUserForm')}}" class="btn me-2" title="editProfile"><h5><i class="bi bi-gear edit-icon"></i></h5></a>
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" title="Delete profile"><h5><i class="bi bi-x-circle delete-icon"></i></h5></button>
                                    </div>
                                @endif
                            @endauth
                        </div>
                    </div>
                    @if($user->description)
                    <div class="align-content-center text-center">
                        <p><i>{{$user->description}}</i></p>
                    </div>
                    @endif

                </div>
            <hr>
            <div class="row mb-3"></div>
                <div class="col-auto">
                    <div class="row mb-3 custom-text">
                        <h4>Ulubione</h4>
                        @if($fav->isNotEmpty())
                            @foreach($fav as $f)
                                <div class="col-md-1 text-center">
                                    <div class="d-flex flex-column align-items-center">
                                        <a href="{{ route('showMovie', ['id' => $f->movie->id]) }}" class="text-decoration-none ms-3">
                                            <img src="data:image/jpeg;base64,{{ base64_encode($f->movie->poster) }}" class="imageArtistMini" alt="Opis obrazu">
                                            <p>{{$f->movie->title}}</p>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p><i>Brak ulubionych filmów!</i></p>
                        @endif
                    </div>
                    <div class="row mb-3 custom-text">
                        <h4>Do obejrzenia</h4>
                        @if($wat->isNotEmpty())
                            @foreach($wat as $w)
                                <div class="col-md-1 text-center">
                                    <div class="d-flex flex-column align-items-center">
                                        <a href="{{ route('showMovie', ['id' => $w->movie->id]) }}" class="text-decoration-none ms-3">
                                            <img src="data:image/jpeg;base64,{{ base64_encode($w->movie->poster) }}" class="imageArtistMini" alt="Opis obrazu">
                                            <p>{{$w->movie->title}}</p>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            <p><i>Brak filmów do obejrzenia.</i></p>
                        @endif
                    </div>
                    @auth
                        @if(auth()->user()->id==$user->id)
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h4>Twoje zasoby oczekujące</h4>
                                    <div class="row">
                                        @forelse($pending as $item)
                                            <div class="col-md-2 text-center">
                                                <div class="d-flex flex-column align-items-center">
                                                    @if($item instanceof \App\Models\Movie)
                                                        <img src="data:image/jpeg;base64,{{ base64_encode($item->poster) }}" class="imageArtistMini" alt="Opis obrazu">
                                                        <p>{{$item->title}}</p>
                                                        <div class="col-md-2 d-flex justify-content-center align-items-center">
                                                            <a href="{{ route('editMovieForm', ['id' => $item->id]) }}" class="text-decoration-none custom-buttons" title="Edytuj film"><i class="bi bi-pen edit-icon ms-2"></i></a>
                                                            <form method="POST" action="{{ route('deleteMovie', ['id' => $item->id]) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn custom-buttons"><i class="bi bi-x-circle delete-icon"></i></button>
                                                            </form>
                                                        </div>
                                                    @elseif($item instanceof \App\Models\Artist)
                                                        <img src="data:image/jpeg;base64,{{ base64_encode($item->image) }}" class="imageArtistMini" alt="Opis obrazu">
                                                        <p>{{$item->name}} {{$item->surname}}</p>
                                                        <div class="col-md-2 d-flex justify-content-center align-items-center">
                                                            <a href="{{ route('editArtistForm', ['id' => $item->id]) }}" class="btn custom-buttons" title="Edit artist"><i class="bi bi-person-gear edit-icon"></i></a>
                                                            <form method="POST" action="{{ route('deleteArtist', ['id' => $item->id]) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn custom-buttons"><i class="bi bi-person-fill-slash delete-icon"></i></button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @empty
                                            <p><i>Brak filmów lub artystów oczekujących</i></p>
                                        @endforelse
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <h4>Twoje zasoby odrzucone</h4>
                                    <div class="row">
                                        @forelse($rejected as $item)
                                            <div class="col-md-2 text-center mb-3 me-2">
                                                <div class="d-flex flex-column align-items-center">
                                                    @if($item instanceof \App\Models\Movie)
                                                        <img src="data:image/jpeg;base64,{{ base64_encode($item->poster) }}" class="imageArtistMini" alt="Opis obrazu">
                                                        <p>{{$item->title}}</p>
                                                        <div class="col-md-2 d-flex justify-content-center align-items-center">
                                                            <a href="{{ route('editMovieForm', ['id' => $item->id]) }}" class="text-decoration-none custom-buttons" title="Edytuj film"><i class="bi bi-pen edit-icon ms-3"></i></a>
                                                            <form method="POST" action="{{ route('deleteMovie', ['id' => $item->id]) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn custom-buttons"><i class="bi bi-x-circle delete-icon"></i></button>
                                                            </form>
                                                        </div>
                                                    @elseif($item instanceof \App\Models\Artist)
                                                        <img src="data:image/jpeg;base64,{{ base64_encode($item->image) }}" class="imageArtistMini" alt="Opis obrazu">
                                                        <p>{{$item->name}} {{$item->surname}}</p>
                                                        <div class="col-md-2 d-flex justify-content-center align-items-center">
                                                            <a href="{{ route('editArtistForm', ['id' => $item->id]) }}" class="btn custom-buttons" title="Edit artist"><i class="bi bi-person-gear edit-icon"></i></a>
                                                            <form method="POST" action="{{ route('deleteArtist', ['id' => $item->id]) }}">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn custom-buttons"><i class="bi bi-person-fill-slash delete-icon"></i></button>
                                                            </form>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        @empty
                                            <p><i>Brak filmów lub artystów odrzuconych</i></p>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        @endif

                    @endauth
                </div>
        @guest
        @endguest
    </div>
@endsection
