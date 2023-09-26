<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gebruiker aanmaken - Registratiepagina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <!-- Add this line to include FontAwesome icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</head>

<body>
    @foreach($classes as $class)
    <div class="card mb-4">
        <div class="card-header" data-toggle="collapse" data-target="#class-{{ $class->id }}">
            <h2 class="card-title">{{ $class->name }}</h2>
        </div>
        <div id="class-{{ $class->id }}" class="collapse">
            <ul class="list-group list-group-flush">
                @foreach($scrumteams->where('class_id', $class->id) as $team)
                <li class="list-group-item">
                    <h4 class="card-title" data-toggle="collapse" data-target="#team-{{ $team->id }}">
                        {{ $team->name }}
                    </h4>
                    <div id="team-{{ $team->id }}" class="collapse">
                        <ul class="list-unstyled">
                            @foreach($scrumteamUser->where('team_id', $team->id) as $teamUser)
                            @php
                            $student = $students->where('id', $teamUser->user_id)->first();
                            @endphp
                            <li>
                                @if ($student->present == 1)
                                <i class="fas fa-check text-success"></i>
                                @else
                                <i class="fas fa-times text-danger"></i>
                                @endif
                                {{ $student->firstname }}
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </li>
                @endforeach
            </ul>
        </div>
    </div>
    @endforeach
</body>

</html>