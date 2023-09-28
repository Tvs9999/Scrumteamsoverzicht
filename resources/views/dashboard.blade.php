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