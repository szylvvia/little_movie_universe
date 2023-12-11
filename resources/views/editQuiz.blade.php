@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success" role="alert">
                    {{ session('success') }}
                </div>
            @endif
                @if ($errors->any())
                    <div class="alert alert-danger">
                        <ul>
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            <h3 class="mb-4">Edit quiz <b><i>{{$quiz->title}}</i></b></h3>
            @auth
                <form method="POST" action="{{ route('editQuiz',['id'=>$quiz->id]) }}" enctype="multipart/form-data">
                    @csrf
                    <div class="row mb-3">
                        <label for="title" class="col-md-4 col-form-label text-md-end">{{ __('Title') }}</label>
                        <div class="col-md-6">
                            <input id="title" type="text" class="form-control @error('title') is-invalid @enderror" name="title" value="{{ $quiz->title }}" required autocomplete="title" autofocus>
                            @error('title')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="start_date" class="col-md-4 col-form-label text-md-end">{{ __('Start date') }}</label>
                        <div class="col-md-6">
                            <input id="start_date" type="date" class="form-control @error('start_date') is-invalid @enderror" name="start_date" value="{{ $quiz->start_date }}" required autocomplete="start_date" autofocus>
                            @error('start_date')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="end_date" class="col-md-4 col-form-label text-md-end">{{ __('End date') }}</label>
                        <div class="col-md-6">
                            <input id="end_date" type="date" class="form-control @error('end_date') is-invalid @enderror" name="end_date" value="{{ $quiz->end_date }}" required autocomplete="end_date" autofocus>
                            @error('end_date')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    <div class="row mb-3">
                        <label for="description" class="col-md-4 col-form-label text-md-end">{{ __('Description') }}</label>
                        <div class="col-md-6">
                            <textarea id="description" class="form-control @error('description') is-invalid @enderror" name="description"  autocomplete="description" autofocus>{{ $quiz->description }}</textarea>
                            @error('description')
                            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                            @enderror
                        </div>
                    </div>
                    @foreach($quiz->question as $question)
                        <div class="row mb-3">
                            <label for="question{{$question->id}}" class="col-md-4 col-form-label text-md-end">{{ __('Option ') }}</label>
                            <div class="col-md-6">
                                <input id="question{{$question->id}}" type="text" class="form-control @error('questions.'.$question->id) is-invalid @enderror" name="questions[{{$question->id}}]" value="{{ old('questions.'.$question->id, $question->question) }}" required autocomplete="question{{$question->id}}" autofocus>
                                @error('questions.'.$question->id)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                        <div class="row mb-3">
                            <label for="image{{$question->id}}" class="col-md-4 col-form-label text-md-end">{{ __('Image ') }}{{$question->id}}</label>
                            <div class="col-md-6">
                                <div class="d-flex align-items-center">
                                    <input id="image{{$question->id}}" type="file" class="form-control @error('images.'.$question->id) is-invalid @enderror" name="images[{{$question->id}}]" value="{{ old('images.'.$question->id) }}" autocomplete="off" autofocus>
                                    <div id="jsPosterErrorMessages{{$question->id}}" role="alert"></div>
                                    @if($question->image)
                                        <img src="data:image/jpeg;base64,{{ base64_encode($question->image) }}" height="50" alt="Opis obrazu" class="mx-2">
                                    @endif
                                </div>
                                @error('images.'.$question->id)
                                <span class="invalid-feedback" role="alert">
                                    <strong>{{ $message }}</strong>
                                </span>
                                @enderror
                            </div>
                        </div>
                    @endforeach
                    <div class="row mb-0">
                        <div class="col-md-6 offset-md-4">
                            <button type="submit" class="btn btn-primary">
                                {{ __('Save quiz') }}
                            </button>
                        </div>
                    </div>
                </form>
            @endauth
        </div>
    </div>
@endsection
