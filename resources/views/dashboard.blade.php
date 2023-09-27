@if(!isset($userid))
    <script>
        window.location.href = '{{ route("login") }}'; // Redirect to the login page
    </script>
@endif

<p>User Role: {{ $userRole }}</p>
<p>userid: {{ $userid }}</p>
<p>classid: {{ $studentclassid }}</p>

@extends('layout/app')

@section('content')
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
@endsection