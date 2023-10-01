@extends('layout/app')

@section('content') 

<div id="dashboard">
  <div class="dashboard-content">
    <div class="content-header">
        <h1>Dashboard</h1>
    </div>

  
    @if (Auth::user()->role === 1)
    <div id="scrumteams">
      <scrumteamlist
        :classes="{{ $classesJson }}"
        :scrumteams="{{ $scrumteamsJson }}"
        :scrumteamuser="{{ $scrumteamUserJson }}"
        :students="{{ $studentsJson }}"
      ></scrumteamlist>
    </div> 
    @endif
    
    <div class="attendance">
      @if (Auth::user()->role === 0)
          <h2>Presentie</h2>
          <div class="team">

          @foreach($scrumteamMembers as $member)
          
            <div class="member">
              <p>{{ $member['firstname'] }} </p>
              <div class="status">                
                <form action="/update-status/{{ $member['id'] }}/{{ $member['present'] == 1 ? '0' : '' }}" method="POST" class="status-form">
                @csrf 
                  <div class="present {{ $member['present'] == 1 ? 'active' : '' }}" onclick="submitForm(this)"><i class="fa-solid fa-check"></i></div>
                </form>
                <form action="/update-status/{{ $member['id'] }}/{{ $member['present'] == 0 ? '1' : '' }}" method="POST" class="status-form">
                @csrf 
                  <div class="absent {{ $member['present'] == 0 ? 'active' : '' }}" onclick="submitForm(this)"><i class="fa-solid fa-xmark"></i></div>
                </form>
              </div>
            </div>
            @if (!$loop->last)
            <div class="divider"></div>
            @endif
          @endforeach
                      <!-- <div class="absent active"><i class="fa-solid fa-xmark"></i></div> -->

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
    
    function submitForm(iconElement) {
    const formElement = iconElement.closest('.status-form');
    formElement.submit();
}
    
</script>

<!-- collapse scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


