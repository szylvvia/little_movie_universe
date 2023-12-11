@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
            <h1>Add Movie</h1>
            <form method="POST" action="{{ route('addMovie') }}" enctype="multipart/form-data">
                @csrf
                <div class="row mb-3">
                    <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Tittle') }}</label>
                    <div class="col-md-6">
                        <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ old('title') }}" required autocomplete="title" autofocus>
                        @error('title')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="releaseDate" class="col-md-4 col-form-label text-md-end">{{ __('Release date') }}</label>
                    <div class="col-md-6">
                        <input id="releaseDate" min="1888-10-14" max="2099-12-31" type="date" class="form-control @error('releaseDate') is-invalid @enderror" name="releaseDate" value="{{ old('releaseDate') }}" required autocomplete="releaseDate" autofocus>
                        @error('releaseDate')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>
                    <div class="col-md-6">
                        <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description"  autocomplete="description" autofocus>{{ old('description') }}</textarea>
                        @error('description')
                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="trailerLink" class="col-md-4 col-form-label text-md-end">{{ __('Trailer Link') }}</label>
                    <div class="col-md-6">
                        <input id="trailerLink" type="text" class="form-control @error('trailerLink') is-invalid @enderror" name="trailerLink" value="{{ old('trailerLink') }}" required autocomplete="trailerLink" autofocus>
                        @error('trailerLink')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>

                <div class="row mb-3">
                    <label for="soundtrackLink" class="col-md-4 col-form-label text-md-end">{{ __('Soundtrack Link') }}</label>
                    <div class="col-md-6">
                        <input id="soundtrackLink" type="text" class="form-control @error('soundtrackLink') is-invalid @enderror" name="soundtrackLink" value="{{ old('soundtrackLink') }}" required autocomplete="soundtrackLink" autofocus>
                        @error('soundtrackLink')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="mySelectInput" class="col-md-4 col-form-label text-md-end">{{ __('Artists') }}</label>
                    <div class="col-md-6">
                        <select multiple id="mySelectInput" class="form-control @error('soundtrack_link') is-invalid @enderror" name="artists[]" required autocomplete="artists" autofocus>
                            @foreach($artist as $a)
                                <option value="{{$a->id}}">
                                    {{$a->name}} {{$a->surname}}
                                </option>
                            @endforeach
                        </select>
                        @error('artists')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="poster" class="col-md-4 col-form-label text-md-end">{{ __('Poster') }}</label>
                    <div class="col-md-6">
                        <input id="poster" required type="file" class="form-control @error('poster') is-invalid @enderror" name="poster" value="{{ old('poster') }}" autocomplete="poster" autofocus>
                        <div id="jsPosterErrorMessages" role="alert"></div>
                        @error('poster')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                    </div>
                </div>
                <div class="row mb-3">
                    <label for="images" class="col-md-4 col-form-label text-md-end">{{ __('Images') }}</label>
                    <div class="col-md-6">
                        <input multiple required id="images" type="file" class="form-control @error('images') is-invalid @enderror" name="images[]" autocomplete="images" autofocus>
                        <div id="jsImagesErrorMessages" role="alert"></div>
                        @error('images')
                        <span class="invalid-feedback" role="alert">
                            <strong>{{ $message }}</strong>
                        </span>
                        @enderror
                        @if(is_array(old('images')))
                            @foreach(old('images') as $oldImage)
                                <input type="hidden" name="old_images[]" value="{{ $oldImage }}">
                            @endforeach
                        @endif
                    </div>
                </div>
                <div class="row mb-0">
                    <div class="col-md-6 offset-md-4">
                        <button type="submit" class="btn btn-primary">
                            {{ __('Add movie') }}
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>
        <script src="{{ asset('js/multiple.js') }}"></script>
        <script src="{{ asset('js/validFileMovies.js') }}"></script>
@endsection
