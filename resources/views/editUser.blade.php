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
            @auth
            <div class="row mb-3">
                <div class="col-md-8">
                    <h1>Edit profile</h1>
                </div>
                <form method="POST" action="{{route("editUser")}}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{auth()->user()->name}}" required autocomplete="name" autofocus>
                            @error('name')
                            <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="surname" class="col-md-4 col-form-label text-md-end">{{ __('Surname') }}</label>
                        <div class="col-md-6">
                            <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{auth()->user()->surname}}" required autocomplete="surname" autofocus>
                            @error('surname')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="email" class="col-md-4 col-form-label text-md-end">{{ __('Email') }}</label>
                        <div class="col-md-6">
                            <input id="email" type="email" class="form-control @error('email') is-invalid @enderror" name="email" value="{{auth()->user()->email}}" required autocomplete="email" autofocus>
                            @error('email')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="birth_date" class="col-md-4 col-form-label text-md-end">{{ __('Birth date') }}</label>
                        <div class="col-md-6">
                            <input id="birth_date" type="date" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{auth()->user()->birth_date}}" required autocomplete="birth_date" autofocus>
                            @error('birth_date')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>
                        <div class="col-md-6">
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description" autocomplete="description" autofocus placeholder="Write something about you"></textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Image') }}</label>
                        <div class="col-md-6">
                            <input type="file" id="image" class="form-control @error('image') is-invalid @enderror" name="image" autocomplete="image">
                            <div id="jsImageErrorMessages" class="customError" role="alert"></div>
                            @error('image')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="background" class="col-md-4 col-form-label text-md-end">{{ __('Background') }}</label>
                        <div class="col-md-6">
                            <input type="file" id="background" class="form-control @error('background') is-invalid @enderror" name="background" autocomplete="background">
                            <div id="jsBackgroundErrorMessages" class="customError" role="alert"></div>
                            @error('background')
                            <span class="invalid-feedback" role="alert">
                                <strong>{{ $message }}</strong>
                            </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Edit profile') }}
                            </button>
                        </div>
                    </div>
                </form>
            @endauth
            </div>
        </div>
    </div>
    <script src="{{ asset('js/validFileUser.js') }}"></script>
@endsection
