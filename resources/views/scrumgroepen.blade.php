@extends('layout/app')

@section('content')

@if(Session::has('success'))
<div class="success-message" id="success-message" role="alert">
    {{ Session::get('success') }}
</div>
@endif

@if(Session::has('error'))
<div class="error-popup" id="error-message" role="alert">
    {{ Session::get('error') }}
</div>
@endif

@if ($errors->any())
    <div class="error-message">
        @foreach ($errors->all() as $error)
            <p>{{ $error }}</p>
        @endforeach
    </div>
@endif

<div id="scrumteams">
    <div class="content-header">
        <h1>Scrumteams</h1>
        <div class="tabs">
            <div class="tab active" data-target="active-content">Actief</div>
            <div class="divider"></div>
            <div class="tab" data-target="archived-content">Archief</div>
        </div>
    </div>
    
    <div id="scrumteamsList">
        <div class="content active" id="active-content">
            <scrumteamlist 
                :classes="{{ $activeClassesJson }}" 
                :active="true"
                :dashboard="false"
            ></scrumteamlist>
        </div>
        <div class="content" id="archived-content">
            <scrumteamlist 
                :classes="{{ $archivedClassesJson }}"
                :active="false"
                :dashboard="false"
            ></scrumteamlist>
        </div>
    </div>

    <div class="add-scrumteam">
        <a href="/addScrumteam"><i class="fa-solid fa-plus"></i></a>
    </div>
</div>

@endsection

<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // previous page should be reloaded when user navigate through browser navigation
    // for mozilla
    window.onunload = function() {};
    // for chrome
    if (window.performance && window.performance.navigation.type === window.performance.navigation.TYPE_BACK_FORWARD) {
        location.reload();
    }

    $(document).ready(function () {
        $(".tab").click(function () {            
            // Remove 'active' class from all tabs
            $(this).siblings(".tab").removeClass("active");
            
            // Add 'active' class to the clicked tab
            $(this).addClass("active");
            
            // Get the target content ID from the 'data-target' attribute
            const targetId = $(this).data("target");
            
            // Hide all content elements
            $(".content").removeClass("active");
            
            // Show the content element with the matching ID
            $("#" + targetId).addClass("active");
        });
    });
</script>
