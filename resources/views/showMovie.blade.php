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
            <div class="row mb-3">
                <div class="col-md-8">
                    <h1>{{$movie->title}}</h1>
                </div>
            </div>
            @auth
                @if(auth()->user()->id)
                    @if(auth()->user()->id==$movie->user_id or auth()->user()->role=='admin')
                       <div class="row mb-3">
                           <div class="col-md-8">
                            <button type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#confirmDeleteModal">Delete Movie</button>
                            <a href="{{ route('editMovieForm', ['id' => $movie->id]) }}" class="btn btn-warning">Edit Movie</a>
                           </div>
                       </div>
                        <div class="modal fade" id="confirmDeleteModal" tabindex="-1" aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                            <div class="modal-dialog">
                                <div class="modal-content">
                                    <div class="modal-header">
                                        <h5 class="modal-title" id="confirmDeleteModalLabel">Delete</h5>
                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                        Are you sure you want to delete the movie <strong>{{$movie->title}}</strong>?
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                                        <form method="POST" action="{{ route('deleteMovie', ['id' => $movie->id]) }}">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="btn btn-danger">Delete movie</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                        <div class="row mb-3">
                            <div class="col-md-8">
                                <form id="rateForm" method="post" action="{{ route('addOrEditRate', ['id' => $movie->id]) }}" enctype="multipart/form-data">
                                    @csrf
                                    <div class="row mb-0">
                                        <label for="Rating" class="col-md-1 col-form-label text-md-end">{{ __('Rating') }}</label>
                                        <div class="col-md-7">
                                            @for($i=1;$i<=10;$i++)
                                                <label for="rate{{$i}}" class="checkbox-container">
                                                    <input id="rate{{$i}}" value="{{$i}}" name="rate" type="checkbox" {{ $userRate && $userRate->rate == $i ? 'checked' : '' }}>
                                                    <span class="star"></span>
                                                </label>
                                            @endfor
                                                <label for="toClearRate">
                                                    <input type="checkbox" id="toClearRate">
                                                    {{"Clear"}}
                                                </label>
                                            @error('rate')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row mb-0" >
                                        <div id="rateError" class="customError" role="alert"></div>
                                    </div>
                                    <div class="row mb-3">
                                        <label for="review" class="col-md-1 col-form-label text-md-end">{{ __('Review') }}</label>
                                        <div class="col-md-6">
                                        <textarea id="review" class="form-control @error('review') is-invalid @enderror" name="review" autocomplete="review" autofocus placeholder="Your review">@if(isset($userRate) && $userRate->review != null){{ $userRate->review }}@else{{ old("review") }}@endif</textarea>
                                            @error('review')
                                            <span id="reviewError" class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                            @enderror
                                        </div>
                                        <div class="row mb-0" >
                                            <div id="reviewError" class="customError" role="alert"></div>
                                        </div>
                                    </div>
                                    <div class="row mb-3">
                                        <div class="col-md-6">
                                            <button id="button" type="submit" class="btn btn-primary">
                                                {{ __('Save') }}
                                            </button>
                                        </div>
                                    </div>
                                </form>
                                @isset($userRate)
                                <form method="POST" action="{{ route('deleteRate', ['id' => $movie->id]) }}">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">Delete</button>
                                </form>
                                @endisset
                            </div>
                        </div>
                @endif
            @endauth
                <div class="row mb-3">
                    <h3>Poster</h3>
                    <div class="col-md-6">
                        <img src="data:image/jpeg;base64,{{ base64_encode($movie->poster) }}" alt="Opis obrazu">
                    </div>
                </div>
                <div class="row mb-3">
                    <h3>Trailer</h3>
                    <div class="col-md-6">
                        <iframe  width="600" height="352" src="{{$movie->trailer_link}}" title="{{$movie->title}}" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                    </div>
                </div>
                <div class="row mb-3">
                    <h3>Soundtrack</h3>
                    <div class="col-md-6">
                        <iframe src="{{$movie->soundtrack_link}}" width="600" height="352" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture" loading="lazy"></iframe>
                    </div>
                </div>
        <div class="row mb-3">
            <h3>Artist</h3>
                <ul>
                    @foreach($movie->artist as $a)
                        <li>{{$a->name}} {{$a->surname}} </li>
                        <img src="data:image/jpeg;base64,{{ base64_encode($a->image) }}" alt="Opis obrazu">
                    @endforeach
                </ul>
        </div>
                <div class="row mb-3">
                    <h3>Gallery</h3>
                    <div class="col-md-6">
                        @foreach($movie->image as $i)
                            <img src="data:image/jpeg;base64,{{ base64_encode($i->image) }}" alt="Opis obrazu">
                        @endforeach
                    </div>
                </div>
                <div class="row mb-3">
                    <h3>Rates & Review</h3>
                    @foreach($movie->rate as $r)
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="col-md-1">
                                    <img src="{{$r->user->image}}" class="rounded-circle user-image-medium" alt="Opis obrazu">
                                    <div class="mt-2 text-center">
                                        <b>{{$r->user->name}} {{$r->user->surname}}</b>
                                    </div>
                                </div>

                                <div class="col-md-6 pt-4 pb-3">
                                    <div class="d-flex flex-column">
                                        <div class="mb-2">
                                            @for($i=1;$i<=10;$i++)
                                                @if($i<=$r->rate)
                                                    <img src="{{asset('img/Gold_Star.png')}}" alt="star" class="little-star">
                                                @else
                                                    <img src="{{asset('img/Grey_Star.png')}}" alt="star" class="little-star">
                                                @endif
                                            @endfor
                                        </div>
                                        <div>
                                            <i>{{$r->review}}</i>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
    </div>
    <script src="{{asset('js/rating.js')}}"></script>
@endsection
