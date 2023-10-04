@extends('layout/app')

@section('content')

@if(Session::has('success'))
<div class="success-message" id="success-message" role="alert">
    {{ Session::get('success') }}
</div>
@endif

<div id="scrumteams">
    <div class="content-header">
        <h1>Scrumteams</h1>
    </div>
    <div id="scrumteamsList">
        
        <div class="activeClasses">

            <scrumteamlist 
                :classes="{{ $activeClassesJson }}" 
                {{-- :archive="{{ $archive }}" --}}
            ></scrumteamlist>
        </div>
        <div class="archivedClasses">
            <scrumteamlist 
                :classes="{{ $archivedClassesJson }}" 
                {{-- :archive="{{ $archive }}" --}}
            ></scrumteamlist>
        </div>
    </div>

    <div class="add-scrumteam">
        <a href="/addScrumteam"><i class="fa-solid fa-plus"></i></a>
    </div>
</div>

@endsection

<script>
    // previous page should be reloaded when user navigate through browser navigation
    // for mozilla
    window.onunload = function() {};
    // for chrome
    if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_BACK_FORWARD) {
        location.reload();
    }
</script>

<!-- collapse scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>