@extends('layouts.app')

@section('content')
    <div class="container">
        @auth
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
                        <img src="{{ Auth::user()->image }}" alt="User image" class="rounded-circle user-image-medium">
                    </div>
                    <div class="align-content-center text-center">
                        <h3>{{Auth::user()->name}} {{Auth::user()->surname}}</h3>
                    </div>
                    @if(Auth::user()->desccription)
                    <div class="align-content-center text-center">
                        <p><i>{{Auth::user()->description}}</i></p>
                    </div>
                    @endif
                    @if(Auth::user()->id)
                    <div class="row mb-3">
                        <div class="col-auto">
                            <a href="{{ route('editUserForm')}}" class="btn btn-warning">Edit profile</a>
                        </div>
                        <div class="col-auto">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">Delete profile</button>
                        </div>
                    </div>
                    @endif
                </div>
            <hr>
            <div class="row mb-3"></div>
                <div class="col-auto">
                    <div class="row mb-3">
                        <h4>Favorite</h4>
                        @foreach($fav as $f)
                            <p>{{$f->movie->title}}</p>
                        @endforeach
                    </div>
                    <div class="row mb-3">
                        <h4>To watch</h4>
                        @foreach($wat as $w)
                            <p>{{$w->movie->title}}</p>
                        @endforeach
                    </div>
                </div>

        @endauth
        @guest
        @endguest
    </div>
@endsection
