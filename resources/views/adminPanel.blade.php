@extends('layouts.app')

@section('content')
    <div class="container">
        <div class="row">
            <h3>Admin panel</h3>
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
                <a href="{{route("addQuizForm")}}" class="btn btn-outline-info"><i class="bi bi-patch-plus"></i> Create new quiz</a>
            </div>
        </div>

        <div class="row mt-4">
            <h4>Pending movies</h4>
            <div class="row p-4">
            <table class="table">
                <thead>
                <tr>
                    <th scope="col">ID</th>
                    <th scope="col" class="col-md-3">Title</th>
                    <th scope="col" class="col-md-2">Release date</th>
                    <th scope="col" class="col-md-3">Description</th>
                    <th scope="col" class="col-md-3">Date added</th>
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
                                        <button type="submit" class="btn btn-outline-success mx-1">Verify</button>
                                    </form>
                                    <form method="get" action="{{ route('editMovieForm', ['id' => $p->id]) }}">
                                        @csrf
                                        <button class="btn btn-outline-warning mx-1">Check</button>
                                    </form>
                                    <form method="POST" action="{{ route('verifyMovie', ['id' => $p->id, 'decision' =>'rejected']) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success mx-1">Reject</button>
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
            <h4>Pending artist</h4>
            <div class="row p-4">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col" class="col-md-2">Name and surname</th>
                        <th scope="col">Gender</th>
                        <th scope="col">Profession</th>
                        <th scope="col" class="col-md-2">Birth date</th>
                        <th scope="col" class="col-md-2" >Death date</th>
                        <th scope="col" class="col-md-4" >Description</th>
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
                                        <button type="submit" class="btn btn-outline-success mx-1">Verify</button>
                                    </form>
                                    <form>
                                        @csrf
                                        <button class="btn btn-outline-warning mx-1">Check</button>
                                    </form>
                                    <form method="POST" action="{{ route('verifyArtist', ['id' => $a->id, 'decision' =>'rejected']) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-success mx-1">Reject</button>
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
            <h4>Your quizzes</h4>
            <div class="row p-4">
                <table class="table">
                    <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col" class="col-md-2">Tittle</th>
                        <th scope="col" class="col-md-2">Description</th>
                        <th scope="col" class="col-md-2">Start date</th>
                        <th scope="col" class="col-md-2">End date</th>
                        <th scope="col" class="col-md-3">Options</th>
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
                                    <a href="{{ route('editQuizForm',['id' => $q->id])}} " class="text-decoration-none"><button type="submit" class="btn btn-outline-warning mx-1">Edit</button></a>
                                    <form method="POST" action="{{ route('verifyArtist', ['id' => $a->id, 'decision' =>'rejected']) }}">
                                        @csrf
                                        <button type="submit" class="btn btn-outline-danger mx-1">Delete</button>
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

