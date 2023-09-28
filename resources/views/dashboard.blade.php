@if(!isset($userid))
    <script>
        window.location.href = '{{ route("login") }}'; // Stuur naar login pagina als de userid niet bestaat
    </script>
@endif

<p>User Role: {{ $userRole }}</p>
<p>userid: {{ $userid }}</p>
<p>classid: {{ $studentclassid }}</p>

@extends('layout/app')

@section('content') 


<div id="scrumteams">
  <ScrumTeamList
    :classes="{{ $classesJson }}"
    :scrumteams="{{ $scrumteamsJson }}"
    :scrumteam-user="{{ $scrumteamUserJson }}"
    :students="{{ $studentsJson }}"
  ></ScrumTeamList>
</div>  
@endsection

<script>
    // previous page should be reloaded when user navigate through browser navigation
    // for mozilla
    window.onunload = function(){};
    // for chrome
    if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_BACK_FORWARD) {
        location.reload();
    }
</script>