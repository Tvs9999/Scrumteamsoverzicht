@extends('layout/app')

@section('content')
<head>
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.4/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
</head>
<div id="addScrumteam">
        <div class="content-header">
            <h1>Scrumteam toevoegen</h1>
        </div>
        <div class="add-form">
            <form action="{{ route('addScrumteam.post') }}" method="POST">
                @csrf
                <div class="input">
                    <label for="name">Naam</label>
                    <input type="text" id="name" name="name" placeholder="Vul hier het scrumteam in" required>
                </div>
                <div class="input-row">
                    <div class="input">
                        <label for="class">Klas</label>
                        <select name="class_id" id="klas" required>
                            <option value="" disabled selected>Selecteer een klas</option>
                            @foreach ($classes as $class)
                            <option value="{{$class->id}}">{{$class->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <input hidden value="{{$scrumteamid}}" name="team_id">
                    <div class="input">
                        <label for="students">Leerlingen</label>
                    </div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Voeg leerlingen toe
                    </button>
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                    <div class="modal-dialog" role="document">
                        <div class="modal-content">
                        <div class="modal-header">
                            <h5 class="modal-title" id="exampleModalLabel">Voeg leerlingen toe</h5>
                            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                        <div class="modal-body">
                            <input name="findstudent" placeholder="Zoek een leerling"><br>
                            @foreach ($users as $user)
                            <input type="checkbox" value="{{$user->id}}" name="user_id[]">{{$class->name}} {{$user->firstname}} {{$user->lastname}}
                            @endforeach
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-dismiss="modal">Leerling Selecteren</button>
                            
                        </div>
                        </div>
                    </div>
                    </div>
                    </div>
                </div>
                <button type="submit">Scrumteam aanmaken</button>
            </form>
        </div>
    </div>
@endsection
