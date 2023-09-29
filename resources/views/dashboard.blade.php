@extends('layout/app')

@section('content') 

<div id="dashboard">
  <div class="dashboard-content">
    <div class="content-header">
        <h1>Dashboard</h1>
    </div>
  
    <div id="scrumteams">
      {{-- <scrumteamlist
        :classes="{{ $classesJson }}"
        :scrumteams="{{ $scrumteamsJson }}"
        :scrumteamuser="{{ $scrumteamUserJson }}"
        :students="{{ $studentsJson }}"
      ></scrumteamlist> --}}
    </div> 
    
    <div class="attendance">
      @if (Auth::user()->role === 0)
          <h2>Presentie</h2>
          <div class="team">
            <div class="member">
              <p>Tobias van Spnning</p>
              <div class="status">
                <form action="">
                  <div class="present active"><i class="fa-solid fa-check"></i></div>
                </form>
                <form action="">
                  <div class="absent"><i class="fa-solid fa-xmark"></i></div>
                </form>
              </div>
            </div>
            <div class="divider"></div>
            <div class="member">
              <p>Tobias van Spnning</p>
              <div class="status">
                <form action="">
                  <div class="present active"><i class="fa-solid fa-check"></i></div>
                </form>
                <form action="">
                  <div class="absent"><i class="fa-solid fa-xmark"></i></div>
                </form>
              </div>
            </div>
            <div class="divider"></div>
            <div class="member">
              <p>Tobias van Spnning</p>
              <div class="status">
                <form action="">
                  <div class="present"><i class="fa-solid fa-check"></i></div>
                </form>
                <form action="">
                  <div class="absent active"><i class="fa-solid fa-xmark"></i></div>
                </form>
              </div>
            </div>
          </div>
      @endif
    </div>
  </div>

  <div class="your-info">
    <div class="your-workshops">
      <h2>Jouw workshops</h2>
      <div class="workshop">
        <div class="icon"><i class="fa-solid fa-chalkboard-user"></i></div>
        <div class="info">
          <h5>Workshop 1</h5>
          <p>locatie - datum en tijd - leraar</p>
        </div>
      </div>
      <div class="workshop">
        <div class="icon"><i class="fa-solid fa-chalkboard-user"></i></div>
        <div class="info">
          <h5>Workshop 1</h5>
          <p>locatie - datum en tijd - leraar</p>
        </div>
      </div>
    </div>
    <div class="divider"></div>
    <div class="your-questions">
      <h2>Jouw vragen</h2>
      <div class="question">
        <div class="icon"><i class="fa-solid fa-question"></i></div>
        <div class="question-info">
          <h5>Kan ik geholpen worden met het begrijpen van Laravel?</h5>
          <p>Onafgerond</p>
        </div>
      </div>
      <div class="question">
        <div class="icon"><i class="fa-solid fa-question"></i></div>
        <div class="question-info">
          <h5>Kan ik geholpen worden met het begrijpen van Laravel?</h5>
          <p>Onafgerond</p>
        </div>
      </div>
    </div>
    <button class="ask-question">Stel een vraag<i class="fa-solid fa-message"></i></button>
  </div>
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

