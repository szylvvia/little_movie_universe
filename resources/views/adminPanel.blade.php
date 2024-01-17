@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Panel administratora</h3>
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
                    @if($errors->any())
                        <div class="alert alert-danger">
                            <ul>
                                @foreach($errors->all() as $error)
                                    <li>{{ $error }}</li>
                                @endforeach
                            </ul>
                        </div>
                    @endif
            </div>
        </div>

        <div class="row mt-1">
            <div class="col-md-6">
                <a href="{{route("addQuizForm")}}" class="btn add-button"><i class="bi bi-plus"></i> Stwórz nowy quiz</a>
            </div>
        </div>

        <div class="row mt-4">
            <h4>Oczekujące filmy</h4>
            <div class="row p-4">
            <table class="table table-color">
                <thead>
                <tr class="custom-tr">
                    <th scope="col">ID</th>
                    <th scope="col" class="col-md-3">Tytuł</th>
                    <th scope="col" class="col-md-2">Data premiery</th>
                    <th scope="col" class="col-md-3">Opis filmu</th>
                    <th scope="col" class="col-md-3">Data dodania</th>
                    <td></td>
                </tr>
                </thead>
                <tbody>
                    @foreach($pendingMovies as $p)
                        <tr>
                            <th scope="row">{{$p->id}}</th>
                            <td>{{$p->title}}</td>
                            <td>{{$p->release_date}}</td>
                            <td>{{$p->description}}</td>
                            <td>{{$p->created_at}}</td>
                            <td>
                                <div class="btn-group">
                                    <form method="POST" action="{{ route('verifyMovie', ['id' => $p->id, 'decision' =>'verified']) }}">
                                        @csrf
                                        <button type="submit" class="btn mx-1"><h4><i class="bi bi-check-lg add-icon-admin"></i></h4></button>
                                    </form>
                                    <form method="get" action="{{ route('editMovieForm', ['id' => $p->id]) }}">
                                        @csrf
                                        <button class="btn mx-1"><h5><i class="bi bi-pen edit-icon"></i></h5></button>
                                    </form>
                                    <form method="POST" action="{{ route('verifyMovie', ['id' => $p->id, 'decision' =>'rejected']) }}">
                                        @csrf
                                        <button type="submit" class="btn mx-1"><h5><i class="bi bi-x-lg delete-icon"></i></h5></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            </div>
        </div>

        <div class="row">
            <h4>Oczekujący artyści</h4>
            <div class="row p-4">
                <table class="table table-color">
                    <thead>
                    <tr class="custom-tr">
                        <th scope="col">ID</th>
                        <th scope="col" class="col-md-2">Imie i nazwisko</th>
                        <th scope="col">Płeć</th>
                        <th scope="col">Zawód</th>
                        <th scope="col" class="col-md-2">Data urodzenia</th>
                        <th scope="col" class="col-md-2" >Data śmierci</th>
                        <th scope="col" class="col-md-4" >Opis</th>
                        <td class="col-md-1" ></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($pendingArtist as $a)
                        <tr>
                            <th scope="row">{{$a->id}}</th>
                            <td>{{$a->name}} {{$a->surname}}</td>
                            <td>{{$a->gender}}</td>
                            <td>{{$a->profession}}</td>
                            <td>{{$a->birth_date}}</td>
                            <td>{{$a->death_date}}</td>
                            <td>{{$a->description}}</td>
                            <td>
                                <div class="btn-group">
                                    <form method="POST" action="{{ route('verifyArtist', ['id' => $a->id, 'decision' =>'verified']) }}">
                                        @csrf
                                        <button type="submit" class="btn mx-1"><h4><i class="bi bi-check-lg add-icon-admin"></i></h4></button>
                                    </form>
                                    <form>
                                        @csrf
                                        <button class="btn mx-1"><h5><i class="bi bi-pen edit-icon"></i></h5></button>
                                    </form>
                                    <form method="POST" action="{{ route('verifyArtist', ['id' => $a->id, 'decision' =>'rejected']) }}">
                                        @csrf
                                        <button type="submit" class="btn mx-1"><h5><i class="bi bi-x-lg delete-icon"></i></h5></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        <div class="row">
            <h4>Twoje quizy</h4>
            <div class="row p-4">
                <table class="table table-color">
                    <thead>
                    <tr class="custom-tr">
                        <th scope="col">ID</th>
                        <th scope="col" class="col-md-2">Nazwa</th>
                        <th scope="col" class="col-md-2">Opis</th>
                        <th scope="col" class="col-md-2">Data rozpoczęcia</th>
                        <th scope="col" class="col-md-2">Data zakończenia</th>
                        <th scope="col" class="col-md-3">Opcje wyboru</th>
                        <td></td>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($quizzes as $q)
                        <tr>
                            <th scope="row">{{$q->id}}</th>
                            <td>{{$q->title}}</td>
                            <td>{{$q->description}}</td>
                            <td>{{$q->start_date}}</td>
                            <td>{{$q->end_date}}</td>
                            <td>
                                <div class="d-flex flex-wrap" style="gap: 2px;">
                                    @foreach($q->question as $qu)
                                        <div class="group"></div>
                                        <p>{{$qu->question}}</p>
                                    @endforeach
                                </div>
                            </td>
                            <td>
                                <div class="btn-group">
                                    <a href="{{ route('editQuizForm',['id' => $q->id])}} " class="text-decoration-none"><button type="submit" class="btn mx-1"><h5><i class="bi bi-pen edit-icon"></i></h5></button></a>
                                    <form method="post" action="{{ route('deleteQuiz', ['id' => $q->id]) }}">
                                        @csrf
                                        <button type="submit" class="btn mx-1"><h5><i class="bi bi-x-lg delete-icon"></i></h5></button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>


    </div>
@endsection

