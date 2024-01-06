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
            <h3>Dodaj nowy quiz</h3>
            @auth
                <form class="form" method="POST" action="{{ route('addQuiz') }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Nazwa quizu') }}</label>
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
                        <label for="start_date" class="col-md-4 col-form-label text-md-end">{{ __('Data rozpoczęcia') }}</label>
                        <div class="col-md-6">
                            <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ old('start_date') }}" required autocomplete="start_date" autofocus>
                            @error('start_date')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="end_date" class="col-md-4 col-form-label text-md-end">{{ __('Data zakończenia') }}</label>
                        <div class="col-md-6">
                            <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ old('end_date') }}" required autocomplete="end_date" autofocus>
                            @error('end_date')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Opis quizu') }}</label>
                        <div class="col-md-6">
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description"  autocomplete="description" autofocus>{{ old('description') }}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    @for($i=1; $i<=3; $i++)
                        <div class="row mb-3">
                            <label for="option{{$i}}" class="col-md-4 col-form-label text-md-end">{{ __('Opcja ') }}{{$i}}</label>
                            <div class="col-md-6">
                                <input id="option{{$i}}" type="text" class="form-control @error('options.'.$i) is-invalid @enderror" name="options[{{$i}}]" value="{{ old('options.'.$i) }}" required autocomplete="option{{$i}}" autofocus>
                                @error('options.'.$i)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="image{{$i}}" class="col-md-4 col-form-label text-md-end">{{ __('Obraz ') }}{{$i}}</label>
                            <div class="col-md-6">
                                <input id="image{{$i}}" required type="file" class="form-control @error('images.'.$i) is-invalid @enderror" name="images[{{$i}}]" value="{{ old('images.'.$i) }}" autocomplete="off" autofocus>
                                <div id="jsPosterErrorMessages{{$i}}" role="alert"></div>
                                @error('images.'.$i)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    @endfor
                        <div class="row mb-0">
                            <div class="col-md-6 offset-md-4">
                                <button type="submit" class="btn add-button">
                                    <i class="bi bi-plus"></i>{{ __(' Dodaj quiz') }}
                                </button>
                            </div>
                        </div>
                </form>
            @endauth
        </div>
    </div>
@endsection
