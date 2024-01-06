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
            <h1>Add artist</h1>
                @auth
            <form class="form" method="POST" action="{{ route('addArtist') }}" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <label for="name" class="col-md-4 col-form-label text-md-end">{{ __('Imie') }}</label>
                    <div class="col-md-6">
                        <input id="name" type="text" class="form-control @error('name') is-invalid @enderror" name="name" value="{{ old('name') }}" required autocomplete="name" autofocus>

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
                        <input id="surname" type="text" class="form-control @error('surname') is-invalid @enderror" name="surname" value="{{ old('surname') }}" required autocomplete="surname" autofocus>
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
                        <select id="gender" class="form-control @error('gender') is-invalid @enderror" name="gender" value="{{ old('gender') }}" autocomplete="gender" autofocus required>
                            <option value="Kobieta">Kobieta</option>
                            <option value="Mężczyzna">Mężczyzna</option>
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
                        <input id="birth_date" type="date" min="18-01-01" max="2099-12-31" class="form-control @error('birth_date') is-invalid @enderror" name="birth_date" value="{{ old('birth_date') }}" required autocomplete="birth_date" autofocus>
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
                        <input id="death_date" min="18-01-01" max="2099-12-31" type="date" class="form-control @error('death_date') is-invalid @enderror" name="death_date" value="{{ old('death_date') }}" autocomplete="death_date" autofocus>
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
                        <input id="description" type="text" class="form-control @error('description') is-invalid @enderror" name="description" value="{{ old('description') }}" autocomplete="description" autofocus>
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
                            <option value="Aktor">Aktor</option>
                            <option value="Reżyser">Reżyser</option>
                            <option value="Scenarzysta">Scenarzysta</option>
                            <option value="Kompozytor">Kompozytor</option>
                            <option value="Producent">Poducent</option>
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
                        <input id="image" type="file" class="form-control @error('image') is-invalid @enderror" name="image" value="{{ old('image') }}" autocomplete="image" autofocus>
                        <div id="jsImageErrorMessages" class="customError" role="alert"></div>
                        @error('image')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn add-button">
                            <i class="bi bi-plus"></i>{{ __(' Dodaj artystę') }}
                        </button>
                    </div>
                </div>
            </form>
                @endauth
        </div>
        <script src="{{ asset('js/validFileArtists.js') }}"></script>
@endsection
