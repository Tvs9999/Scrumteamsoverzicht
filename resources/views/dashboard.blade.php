@extends('layout/app')

@section('content')

<div id="dashboard">
  
  @if(Session::has('success'))
    <div class="success-message" id="success-message" role="alert">
        {{ Session::get('success') }}
    </div>
  @endif
  
  <div class="dashboard-content">
    <div class="content-header">
      <h1>Dashboard</h1>
    </div>
  
    {{-- <div id="scrumteams">
      <scrumteamlist
        :classes="{{ $classesJson }}"
        :scrumteams="{{ $scrumteamsJson }}"
        :scrumteamuser="{{ $scrumteamUserJson }}"
        :students="{{ $studentsJson }}"
      ></scrumteamlist>
    </div>  --}}
    
    <div class="dashboard-info">
      @if (Auth::user()->role === 0)
        @if ($scrumteam)
          <div class="team-container">
            <h2>Presentie</h2>
            <div class="team">
              @foreach($scrumteam->scrumteam->users as $member)
                <div class="member">
                  @php
                      $member = $member->user;
                  @endphp
                  <p>{{ $member['firstname'] }} {{$member->lastname}}</p>
                  <div class="status">
                    <form action="{{ $member['present'] == 0 ? '/update-status/' . $member['id'] . '/1' : '' }}" method="POST" class="status-form">
                      @csrf
                      <div class="present {{ $member['present'] == 1 ? 'active' : '' }}" onclick="{{ $member['present'] == 0 ? 'submitForm(this)' : '' }}"><i class="fa-solid fa-check"></i></div>
                    </form>
                    <form action="{{ $member['present'] == 1 ? '/update-status/' . $member['id'] . '/0' : '' }}" method="POST" class="status-form">
                      @csrf
                      <div class="absent {{ $member['present'] == 0 ? 'active' : '' }}" onclick="{{ $member['present'] == 1 ? 'submitForm(this)' : '' }}"><i class="fa-solid fa-xmark"></i></div>
                    </form>
                  </div>
                </div>
                @if (!$loop->last)
                  <div class="divider"></div>
                @endif
              @endforeach
            </div>
          </div>
        @else
          <div class="no-team">
            <p>Geen scrumteam gevonden</p>
          </div>
        @endif

        @elseif (Auth::user()->role === 1)
          <div id="scrumteams">
            <scrumteamlist
              :classes="{{ $classesJson }}"
              :scrumteams="{{ $scrumteamsJson }}"
              :scrumteamuser="{{ $scrumteamUserJson }}"
              :students="{{ $studentsJson }}"
            ></scrumteamlist>
          </div>
        @endif
    </div>
  </div>

  <div class="your-info">
    <div class="your-workshops {{ Auth::user()->role === 0 ? 'student' : 'docent' }}">
      <h2>Jouw workshops</h2>
      <div class="workshops">
        @foreach ($workshops as $workshop)
          <div class="workshop">
            <div class="icon"><i class="fa-solid fa-chalkboard-user"></i></div>
            <div class="info">
              @if (Auth::user()->role === 0)    
                <h5>{{$workshop->workshop->name}}</h5>
                <p>locatie - datum en tijd - leraar</p>
              @elseif (Auth::user()->role === 1)
                <h5>{{$workshop->name}}</h5>
                <p>locatie - datum en tijd - leraar</p>
              @endif
            </div>
          </div>
        @endforeach
      </div>
    </div>
    <div class="divider"></div>
    <div class="questions-container {{ Auth::user()->role === 0 ? 'student' : 'docent' }}">
      @if (Auth::user()->role === 0)  
        <h2>Jouw vragen</h2>
      @elseif (Auth::user()->role === 1)
        <h2>Openstaande vragen</h2>
      @endif
      <div class="questions">
        @foreach ($questions as $question)
          <div class="question">
            <div class="icon"><i class="fa-solid fa-question"></i></div>
            <div class="question-info">
              <h5>{{$question->question}}</h5>
              @if (Auth::user()->role === 0)
                <p>Onafgerond</p>  
              @elseif (Auth::user()->role === 1)
                <p>{{$question->user->firstname}} {{$question->user->lastname}} - {{$question->user->class->name}}</p>  
                <form action="{{ route('completeQuestion') }}" method="POST">
                  @csrf
                  <input name="questionId" id="questionId" type="hidden" value="{{$question->id}}">
                  <button><i class="fa-solid fa-check"></i>Afronden</button>
                </form>
              @endif
            </div>
          </div>
        @endforeach
      </div>
      @if (Auth::user()->role === 0)  
        <button class="ask-question">Stel een vraag<i class="fa-solid fa-message"></i></button>
      @endif
    </div>
  </div>
</div>
<div id="question-modal-container" class="d-none">
  <div class="question-modal">
    <h2 class="modal-title">Wat is je vraag?</h2>
    <div class="close-btn"><i class="fa-solid fa-xmark"></i></div>
    <form action="{{ route('askQuestion') }}" method="POST">
      @csrf
      <div class="input"><input type="text" name="question" id="question" placeholder="Vul hier je vraag in..."></div>
      <button type="submit">Versturen</button>
    </form>
</div>
</div>


@endsection

<!-- collapse scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

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

    $(document).ready(function (){
      $('.ask-question').click(function (){
        $('#question-modal-container').removeClass('d-none');
      });

      $('.close-btn').click(function (){
          $('#question-modal-container').addClass('d-none');
      });
    })
</script>

<!-- collapse scripts -->
<script src="https://cdn.jsdelivr.net/npm/jquery@3.7.1/dist/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>


