@extends("layouts.app")

@section('content')
    <div class="container">
        @if(auth()->user()->id)
            @if(auth()->user()->id==$movie->user_id or auth()->user()->role=='admin')
                <h1>Edytujesz film <strong>{{$movie->title}}</strong></h1>
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
                    <form method="POST" action="{{ route('editMovie',['id' => $movie->id]) }}" enctype="multipart/form-data">
                        @csrf
                        <div class="row mb-3">
                            <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Tytuł') }}</label>
                            <div class="col-md-6">
                                <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{$movie->title}}" required autocomplete="title" autofocus>
                                @error('title')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="releaseDate" class="col-md-4 col-form-label text-md-end">{{ __('Data premiery') }}</label>
                            <div class="col-md-6">
                                <input id="releaseDate" min="1888-10-14" max="2099-12-31" type="date" class="form-control @error('releaseDate') is-invalid @enderror" name="releaseDate" value="{{ $movie->release_date }}" required autocomplete="releaseDate" autofocus>
                                @error('releaseDate')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Opis filmu') }}</label>
                            <div class="col-md-6">
                                <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description"  autocomplete="description" autofocus>{{$movie->description}}</textarea>
                                @error('description')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="trailerLink" class="col-md-4 col-form-label text-md-end">{{ __('Link do trailera') }}</label>
                            <div class="col-md-6">
                                <input id="trailerLink" type="text" class="form-control @error('trailerLink') is-invalid @enderror" name="trailerLink" value="{{$movie->trailer_link}}" required autocomplete="trailerLink" autofocus>
                                @error('trailerLink')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>

                        <div class="row mb-3">
                            <label for="soundtrackLink" class="col-md-4 col-form-label text-md-end">{{ __('Link do soundtracku') }}</label>
                            <div class="col-md-6">
                                <input id="soundtrackLink" type="text" class="form-control @error('soundtrackLink') is-invalid @enderror" name="soundtrackLink" value="{{$movie->soundtrack_link}}" required autocomplete="soundtrackLink" autofocus>
                                @error('soundtrackLink')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="mySelectInput" class="col-md-4 col-form-label text-md-end">{{ __('Artyści') }}</label>
                            <div class="col-md-6">
                                <select multiple id="mySelectInput" class="form-control @error('soundtrack_link') is-invalid @enderror" name="artists[]" required autocomplete="artists" autofocus>
                                    @foreach($artist as $a)
                                        <option value="{{ $a->id }}" {{ $movie->artist->contains($a->id) ? 'selected' : '' }}>
                                            {{ $a->name }} {{ $a->surname }}
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
                            <label for="poster" class="col-md-4 col-form-label text-md-end">{{ __('Plakat') }}</label>
                            <div class="col-md-6">
                                <input id="poster" type="file" class="form-control @error('poster') is-invalid @enderror" name="poster" value="{{ old('poster') }}" autocomplete="poster" autofocus>
                                <div id="jsPosterErrorMessages" class="customError" role="alert"></div>
                                @error('poster')
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            @if($movie->poster!=null)
                                <label for="posterToDelete" class="col-md-4 col-form-label text-md-end">{{ __('Obecny plakat') }}</label>
                                <div class="col-md-6">
                                    <img src="data:image/jpeg;base64,{{ base64_encode($movie->poster) }}" height="50" alt="Opis obrazu">
                                </div>
                            @endif
                        </div>
                        <div class="row mb-3">
                            <label for="images" class="col-md-4 col-form-label text-md-end">{{ __('Fotosy z filmu') }}</label>
                            <div class="col-md-6">
                                <input multiple id="images" type="file" class="form-control @error('images') is-invalid @enderror" name="images[]" autocomplete="images" autofocus>
                                <div id="jsImagesErrorMessages" class="customError" role="alert"></div>
                                @error('images')
                                <span id="jsImagesErrorMessages" class="invalid-feedback" role="alert">
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
                        <div class="row mb-3">
                            @if($movie->image()!=null)
                                <label for="imagesToDelete" class="col-md-4 col-form-label text-md-end">{{ __('Fotosy do usunięcia') }}</label>
                                <div class="col-md-6">
                                    @foreach($movie->image as $i)
                                        <input id="imagesToDelete" type="checkbox" value="{{$i->id}}" name="imagesToDelete[]"><img src="data:image/jpeg;base64,{{ base64_encode($i->image) }}" height="50" alt="Opis obrazu">
                                    @endforeach
                                </div>
                            @endif
                        </div>
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn add-button">
                                    <i class="bi bi-check-lg"></i>{{ __(' Zapisz film') }}
                                </button>
                            </div>
                        </div>
                    </form>
           @endif
        @endif
        </div>
        <script src="{{ asset('js/validEditMovieForm.js') }}"></script>
        <script src="{{ asset('js/validFileMovies.js') }}"></script>
@endsection
