@extends("layouts.app")

@section("content")
    <div class="container">
        <div class="card-body">
            @auth
                @if(auth()->user()->id)
                    @if(auth()->user()->id==$artist->user_id or auth()->user()->role=='admin')
                        <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">
                            Delete Artist
                        </button>
                        <a href="{{ route('editArtistForm', ['id' => $artist->id]) }}" class="btn btn-warning">Edit Movie</a>
                        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmDeleteModalLabel">Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete the artist {{$artist->name}} {{$artist->surname}}?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form method="POST" action="{{ route('deleteArtist', ['id' => $artist->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete artist</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endif
            @endauth
                <div class="row justify-content-center">
                    <div class="col-md-3 text-center">
                        <div class="row m-2">
                            <img src="data:image/jpeg;base64,{{ base64_encode($artist->image) }}" alt="Opis obrazu" class="mx-auto d-block">
                        </div>
                        <div class="row">
                            <h1>{{$artist->name}} {{$artist->surname}}</h1>
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
