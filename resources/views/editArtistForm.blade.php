@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <h1>Edit {{$artist->name}} {{$artist->surname}}</h1>
            @auth
                <form method="POST" action="{{ route('editArtist',['id' => $artist->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Name') }}</label>
                        <div class="col-md-6">
                            <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{$artist->name}}" required autocomplete="name" autofocus>
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
                            <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ $artist->surname}}" required autocomplete="surname" autofocus>
                            @error('surname')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="gender" class="col-md-4 col-form-label text-md-end">{{ __('Gender') }}</label>
                        <div class="col-md-6">
                            <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender" autocomplete="gender" autofocus required>
                                <option value="Female" @if($artist->gender == 'Female') selected @endif>Female</option>
                                <option value="Male" @if($artist->gender == 'Male') selected @endif>Male</option>
                            </select>
                            @error('gender')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="birth_date" class="col-md-4 col-form-label text-md-end">{{ __('BirthDate') }}</label>

                        <div class="col-md-6">
                            <input id="birth_date" type="date" min="18-01-01" max="2099-12-31" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ $artist->birth_date }}" required autocomplete="birth_date" autofocus>
                            @error('birth_date')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="death_date" class="col-md-4 col-form-label text-md-end">{{ __('DeathDate') }}</label>

                        <div class="col-md-6">
                            <input id="death_date" min="18-01-01" max="2099-12-31" type="date" class="form-control @error('death_date') is-invalid @enderror" name="death_date" value="{{ $artist->death_date }}" autocomplete="death_date" autofocus>
                            @error('death_date')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Decription') }}</label>
                        <div class="col-md-6">
                            <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ $artist->description }}" autocomplete="description" autofocus>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="profession" class="col-md-4 col-form-label text-md-end">{{ __('Profession') }}</label>
                        <div class="col-md-6">
                            <select id="profession" class="form-control @error('profession') is-invalid @enderror" name="profession" value="{{ old('profession') }}" autocomplete="profession" autofocus required>
                                <option value="Actor" @if($artist->profession == 'Actor') selected @endif >Actor</option>
                                <option value="Director" @if($artist->profession == 'Director') selected @endif >Director</option>
                                <option value="Screenwriter" @if($artist->profession == 'Screenwriter') selected @endif >Screenwriter</option>
                                <option value="Musican" @if($artist->profession == 'Musican') selected @endif >Musician</option>
                                <option value="Producer"  @if($artist->profession == 'Producer') selected @endif >Producer</option>
                            </select>
                            @error('profession')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Image') }}</label>
                        <div class="col-md-6">
                            <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" autocomplete="image" autofocus>
                            <div id="jsImageErrorMessages" class="customError" role="alert"></div>
                            @error('image')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        @if($artist->image!=null)
                            <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Current image') }}</label>
                            <div class="col-md-6">
                                <img src="data:image/jpeg;base64,{{ base64_encode($artist->image) }}" height="50" alt="Opis obrazu">
                            </div>
                        @endif
                    </div>
                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save') }}
                            </button>
                        </div>
                    </div>
                </form>
            @endauth
        </div>
        <script src="{{ asset('js/validFileArtists.js') }}"></script>
@endsection
