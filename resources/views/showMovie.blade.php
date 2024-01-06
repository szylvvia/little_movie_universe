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
                <div class="row">
                    <div class="col-md-3">
                        <img class="quiz-image" src="data:image/jpeg;base64,{{ base64_encode($movie->poster) }}" alt="Opis obrazu">
                    </div>
                    <div class="col-md-9">
                        <div class="col-md-12 d-flex align-items-center ms-5">
                        <h1>{{$movie->title}}</h1>
                        @auth
                            @if(auth()->user()->id)
                                @if(auth()->user()->id==$movie->user_id or auth()->user()->role=='admin')
                                            <button type="button" class="btn" data-bs-toggle="modal"
                                                    data-bs-target="#confirmDeleteModal" title="Usuń film"><i class="bi bi-x-circle delete-icon"></i>
                                            </button>
                                            <a href="{{ route('editMovieForm', ['id' => $movie->id]) }}" class="text-decoration-none" title="Edytuj film"><i class="bi bi-pen edit-icon"></i></a>
                        </div>
                                    <div class="modal fade" id="confirmDeleteModal" tabindex="-1"
                                         aria-labelledby="confirmDeleteModalLabel" aria-hidden="true">
                                        <div class="modal-dialog">
                                            <div class="modal-content">
                                                <div class="modal-header">
                                                    <h5 class="modal-title" id="confirmDeleteModalLabel">Usuń film</h5>
                                                    <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Anuluj"></button>
                                                </div>
                                                <div class="modal-body">
                                                    Czy na pewno chcesz usunąć film <strong>{{$movie->title}}</strong>?
                                                </div>
                                                <div class="modal-footer">
                                                    <button type="button" class="btn add-button" data-bs-dismiss="modal">Anuluj
                                                    </button>
                                                    <form method="POST" action="{{ route('deleteMovie', ['id' => $movie->id]) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit" class="btn btn-danger">Usuń</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                            @endif
                        @endauth
                        <p class="ms-5"><i>{{$movie->description}}</i></p>
                        <p class="ms-5">Release date {{$movie->release_date}}</p>
                        <div class="mb-4 ms-5">
                            <img src="{{asset('img/Gold_Star.png')}}" alt="star" class="little-star">
                            <span class="ml-2">{{number_format($avgRate,1)}}</span>
                        </div>
                        <div class="row ms-3">
                            @foreach($movie->artist as $a)
                                <div class="col-md-2 text-center custom-text">
                                    <div class="d-flex flex-column align-items-center">
                                        <a href="{{ route('showArtist', ['id' => $a->id]) }}" class="text-decoration-none">
                                            <img src="data:image/jpeg;base64,{{ base64_encode($a->image) }}" class="imageArtistMini" alt="Opis obrazu">
                                            <p>{{$a->name}} {{$a->surname}} </p>
                                        </a>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>

            <div class="row mb-3">
                <div class="col-md-8">
                    <iframe class="trailer" height="352" src="{{$movie->trailer_link}}" title="{{$movie->title}}"
                            allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                            allowfullscreen></iframe>
                </div>
                <div class="col-md-4">
                    <iframe class="soundtrack" src="{{$movie->soundtrack_link}}" height="352" allowfullscreen=""
                            allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"
                            loading="lazy"></iframe>
                </div>
            </div>

            <div class="row mb-3 m-0 rounded-3 align-items-center justify-content-center galleryBackground">
                <div class="col-md-8">
                    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
                        <div class="carousel-inner">
                            @foreach($movie->image as $i)
                                <div class="carousel-item active">
                                    <img src="data:image/jpeg;base64,{{ base64_encode($i->image) }}" class="d-block w-100" alt="Opis obrazu">
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
                            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Previous</span>
                        </button>
                        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
                            <span class="carousel-control-next-icon" aria-hidden="true"></span>
                            <span class="visually-hidden">Next</span>
                        </button>
                    </div>
                </div>
            </div>
            <div class="row mb-3">
                <h3>Rates & Review</h3>
                @auth
                    @if($userRate==null)
                        <div class="col-md-1 mt-3 text-center custom-text ms-3">
                            <div class="d-flex flex-column align-items-center">
                                <img src="{{auth()->user()->image}}" class="rounded-circle user-image-medium"
                                     alt="Opis obrazu">
                                    <b>{{auth()->user()->name}} {{auth()->user()->surname}}</b>
                            </div>
                        </div>
                        <div class="col-md-6 pt-3 pb-3">
                            <div class="d-flex flex-column">
                                <div class="ms-1">
                                    <form id="rateForm" method="post" class="ms-5 form"
                                          action="{{ route('addOrEditRate', ['id' => $movie->id]) }}"
                                          enctype="multipart/form-data">
                                        @csrf
                                        <div class="row mb-0">
                                            <label for="Rating"
                                                   class="col-md-1 col-form-label text-md-end me-2">{{ __('Rating') }}</label>
                                            <div class="col-md-10 m-2">
                                                @for($i=1;$i<=10;$i++)
                                                    <label for="rate{{$i}}" class="checkbox-container">
                                                        <input id="rate{{$i}}" value="{{$i}}" name="rate"
                                                               type="checkbox" {{ $userRate && $userRate->rate == $i ? 'checked' : '' }}>
                                                        <span class="star"></span>
                                                    </label>
                                                @endfor
                                                <input type="checkbox" id="toClearRate" style="display: none;">
                                                <label for="toClearRate"
                                                       class="btn ms-4"
                                                       style="cursor: pointer;">
                                                    <h5><i class="bi bi-eraser delete-icon"></i></h5>
                                                </label>
                                                @error('rate')
                                                <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                @enderror
                                            </div>
                                        </div>
                                        <div class="row mb-0">
                                            <div id="rateError" class="customError" role="alert"></div>
                                        </div>
                                        <div class="row mb-3">
                                            <label for="review"
                                                   class="col-md-1 col-form-label text-md-end me-4">{{ __('Recenzja') }}</label>
                                            <div class="col-md-7">
                                                <textarea id="review"
                                                          class="m-2 form-control @error('review') is-invalid @enderror"
                                                          name="review" autocomplete="review" autofocus
                                                          placeholder="Your review">@if(isset($userRate) && $userRate->review != null)
                                                        {{ $userRate->review }}
                                                    @else
                                                        {{ old("review") }}
                                                    @endif</textarea>
                                                @error('review')
                                                <span id="reviewError" class="invalid-feedback" role="alert">
                                            <strong>{{ $message }}</strong>
                                        </span>
                                                @enderror
                                            </div>
                                            <div class="col-md-1 mt-2">
                                                <button id="button" type="submit"
                                                        class="btn">
                                                    <h5><i class="bi bi-floppy add-icon"></i></h5>
                                                </button>
                                            </div>
                                            <div class="col-md-6 mt-2">
                                                <div id="reviewError" class="customError" role="alert"></div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth
                @auth
                    @if($userRate)
                        <div class="col-md-12 mb-3">
                            <div class="row">
                                <div class="col-md-1 mt-3 text-center custom-text ms-3">
                                    <div class="d-flex flex-column align-items-center">
                                        <img src="{{auth()->user()->image}}" class="rounded-circle user-image-medium"
                                             alt="Opis obrazu">
                                            <b>{{auth()->user()->name}} {{auth()->user()->surname}}</b>
                                    </div>
                                </div>
                                <div class="col-md-6 pt-4 pb-3" id="contentToHide">
                                    <div class="d-flex flex-column">
                                        <div class="mb-2">
                                            @for($i=1;$i<=10;$i++)
                                                @if($i<=$userRate->rate)
                                                    <img src="{{asset('img/Gold_Star.png')}}" alt="star"
                                                         class="little-star">
                                                @else
                                                    <img src="{{asset('img/Grey_Star.png')}}" alt="star"
                                                         class="little-star">
                                                @endif
                                            @endfor
                                        </div>
                                        <div>
                                            <i>{{$userRate->review}}</i>
                                        </div>
                                    </div>
                                    @if($userRate->user_id==auth()->user()->id)
                                        <div class="row mt-2 justify-content-center">
                                            @isset($userRate)
                                                <div class="col-md-2 d-flex justify-content-center align-items-center">
                                                    <button class="btn"
                                                            id="edit-button">
                                                        <h5><i class="bi bi-pencil edit-icon"></i></h5></button>
                                                    <form method="POST"
                                                          action="{{ route('deleteRate', ['id' => $movie->id]) }}">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button class="ms-1 btn"><h5><i
                                                                class="bi bi-trash3 delete-icon"></i></h5></button>
                                                    </form>
                                                </div>
                                            @endisset
                                        </div>
                                    @endif
                                </div>
                                <div class="col-md-6 pt-3 pb-3">
                                    <div id="formContainer" style="display: none;">
                                        <div class="d-flex flex-column">
                                            <div class="ms-5">
                                                <form id="rateForm" method="post" class="ms-5 form"
                                                      action="{{ route('addOrEditRate', ['id' => $movie->id]) }}"
                                                      enctype="multipart/form-data">
                                                    @csrf
                                                    <div class="row mb-0 ms-5">
                                                        <label for="Rating"
                                                               class="col-md-1 col-form-label text-md-end me-3">{{ __('Ocena') }}</label>
                                                        <div class="col-md-10 m-2 ms-2">
                                                            @for($i=1;$i<=10;$i++)
                                                                <label for="rate{{$i}}" class="checkbox-container">
                                                                    <input id="rate{{$i}}" value="{{$i}}" name="rate"
                                                                           type="checkbox" {{ $userRate && $userRate->rate == $i ? 'checked' : '' }}>
                                                                    <span class="star"></span>
                                                                </label>
                                                            @endfor
                                                            <input type="checkbox" id="toClearRate"
                                                                   style="display: none;">
                                                            <label for="toClearRate"
                                                                   class="btn ms-4"
                                                                   style="cursor: pointer; margin-top: -20px;">
                                                                <h5><i class="bi bi-eraser delete-icon"></i></h5>
                                                            </label>
                                                            @error('rate')
                                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                            @enderror
                                                        </div>
                                                    </div>
                                                    <div class="row mb-0">
                                                        <div id="rateError" class="customError" role="alert"></div>
                                                    </div>
                                                    <div class="row mb-3 ps-4 ">
                                                        <label for="review"
                                                               class="col-md-1 col-form-label text-md-end me-4 ps-5">{{ __('Recenzja') }}</label>
                                                        <div class="col-md-7 ms-2">
                                <textarea id="review" class="m-2 form-control @error('review') is-invalid @enderror"
                                          name="review" autocomplete="review" autofocus placeholder="Your review">@if(isset($userRate) && $userRate->review != null){{ $userRate->review }}
                                    @else
                                        {{ old("review") }}
                                    @endif</textarea>
                                                            @error('review')
                                                            <span id="reviewError" class="invalid-feedback"
                                                                  role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                                            @enderror
                                                        </div>
                                                        <div class="col-md-1 mt-2">
                                                            <button id="button" type="submit"
                                                                    class="btn">
                                                                <h5><i class="bi bi-floppy add-icon"></i></h5>
                                                            </button>
                                                        </div>
                                                        <div class="row mb-0">
                                                            <div id="reviewError" class="customError"
                                                                 role="alert"></div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endauth

                @foreach($movie->rate as $r)
                    <div class="col-md-12 mb-3">
                        <div class="row">
                            <div class="col-md-1 mt-3 text-center custom-text ms-3">
                                <div class="d-flex flex-column align-items-center">
                                    <img src="{{$r->user->image}}" class="rounded-circle user-image-medium"
                                         alt="Opis obrazu">
                                        <b>{{$r->user->name}} {{$r->user->surname}}</b>
                                </div>
                            </div>
                            <div class="col-md-6 pt-4 pb-3" id="contentToHide">
                                <div class="d-flex flex-column">
                                    <div class="mb-2">
                                        @for($i=1;$i<=10;$i++)
                                            @if($i<=$r->rate)
                                                <img src="{{asset('img/Gold_Star.png')}}" alt="star"
                                                     class="little-star">
                                            @else
                                                <img src="{{asset('img/Grey_Star.png')}}" alt="star"
                                                     class="little-star">
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
            <script src="{{asset('js/rateAndReviewForm.js')}}"></script>
            <script src="{{asset('js/rating.js')}}"></script>
        </div>
    </div>
@endsection
