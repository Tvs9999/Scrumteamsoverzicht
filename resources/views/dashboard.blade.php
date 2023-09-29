    <!-- <script>
        window.location.href = '{{ route("login") }}'; // Stuur naar login pagina als de userid niet bestaat
    </script> -->



@extends('layout/app')

@section('content') 


<div id="scrumteams">
  <scrumteamlist
    :classes="{{ $classesJson }}"
    :scrumteams="{{ $scrumteamsJson }}"
    :scrumteamuser="{{ $scrumteamUserJson }}"
    :students="{{ $studentsJson }}"
  ></scrumteamlist>
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

