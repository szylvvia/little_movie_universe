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
            <h1>Edytujesz artystę <strong>{{$artist->name}} {{$artist->surname}}</strong></h1>
            @auth
                <form method="POST" action="{{ route('editArtist',['id' => $artist->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Imie') }}</label>
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
                        <label for="surname" class="col-md-4 col-form-label text-md-end">{{ __('Nazwisko') }}</label>

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
                        <label for="gender" class="col-md-4 col-form-label text-md-end">{{ __('Płeć') }}</label>
                        <div class="col-md-6">
                            <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender" autocomplete="gender" autofocus required>
                                <option value="Kobieta" @if($artist->gender == 'Female') selected @endif>Kobieta</option>
                                <option value="Mężczyzna" @if($artist->gender == 'Male') selected @endif>Mężczyzna</option>
                            </select>
                            @error('gender')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>

                    <div class="row mb-3">
                        <label for="birth_date" class="col-md-4 col-form-label text-md-end">{{ __('Data urodzenia') }}</label>

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
                        <label for="death_date" class="col-md-4 col-form-label text-md-end">{{ __('Data śmierci') }}</label>

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
                        <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Opis artysty') }}</label>
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
                        <label for="profession" class="col-md-4 col-form-label text-md-end">{{ __('Zawód') }}</label>
                        <div class="col-md-6">
                            <select id="profession" class="form-control @error('profession') is-invalid @enderror" name="profession" value="{{ old('profession') }}" autocomplete="profession" autofocus required>
                                <option value="Aktor" @if($artist->profession == 'Aktor') selected @endif >Aktor</option>
                                <option value="Reżyser" @if($artist->profession == 'Reżyser') selected @endif >Reżyser</option>
                                <option value="Scenarzysta" @if($artist->profession == 'Scenarzysta') selected @endif >Scenarzysta</option>
                                <option value="Kompozytor" @if($artist->profession == 'Kompozytor') selected @endif >Kompozytor</option>
                                <option value="Producent"  @if($artist->profession == 'Producent') selected @endif >Producent</option>
                            </select>
                            @error('profession')
                            <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Zdjęcie') }}</label>
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
                            <label for="image" class="col-md-4 col-form-label text-md-end">{{ __('Obecne zdjęcie') }}</label>
                            <div class="col-md-6">
                                <img src="data:image/jpeg;base64,{{ base64_encode($artist->image) }}" height="50" alt="Opis obrazu">
                            </div>
                        @endif
                    </div>
                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn add-button">
                                <i class="bi bi-check-lg"></i>{{ __(' Zapisz artystę') }}
                            </button>
                        </div>
                    </div>
                </form>
            @endauth
        </div>
        <script src="{{ asset('js/validFileArtists.js') }}"></script>
@endsection
