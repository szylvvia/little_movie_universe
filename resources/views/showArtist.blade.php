@extends("layouts.app")

@section("content")
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
                <div class="row justify-content-center">
                    <div class="col-md-12 text-center">
                            <img src="data:image/jpeg;base64,{{ base64_encode($artist->image) }}" alt="Opis obrazu" class="mx-auto d-block quiz-image">
                        <div class="row mt-3 justify-content-center">
                            <h1>{{$artist->name}} {{$artist->surname}}</h1>
                            @auth
                                @if(auth()->user()->id)
                                    @if(auth()->user()->id==$artist->user_id or auth()->user()->role=='admin')
                                        <div class="col-md-1 d-flex justify-content-center align-items-center">
                                        <button type="button" class="btn" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal" title="Delete artist">
                                                <h5><i class="bi bi-person-fill-slash delete-icon"></i></h5>
                                        </button>
                                        <a href="{{ route('editArtistForm', ['id' => $artist->id]) }}" class="btn" title="Edit artist"><h5><i class="bi bi-person-gear edit-icon"></i></h5></a>
                                    </div>
                                            <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="confirmDeleteModalLabel">Usuń artystę</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Czy na pewno chcesz usunąć artystę {{$artist->name}} {{$artist->surname}}?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn add-button" data-bs-dismiss="modal">Anuluj</button>
                                                        <form method="POST" action="{{ route('deleteArtist', ['id' => $artist->id]) }}">
                                                            @csrf
                                                            @method('DELETE')
                                                            <button type="submit" class="btn btn-danger">Usuń</button>
                                                        </form>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            @endauth
                        </div>
                        <div class="row">
                        </div>
                        <div class="row">
                            <p>Born {{$artist->birth_date}}</p>
                            @if($artist->death_date!=null)
                                <p>Dead: {{$artist->death_date}}</p>
                            @endif
                        </div>
                        <div class="row">
                            <h5><i>{{$artist->description}}</i></h5>
                        </div>
                        <div class="row">
                            <h5><i>{{$artist->profession}}</i></h5>
                        </div>
                    </div>
                </div>
        </div>
    </div>
@endsection
