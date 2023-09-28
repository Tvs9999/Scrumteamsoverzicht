@extends('layout/app')

@section('content')
    <div id="workshops">

        <div class="content-header">
            <h1>Workshops</h1>
        </div>
        <div class="workshops-container">

            @if(Session::has('success'))
                <div class="success-message" id="success-message" role="alert">
                    {{ Session::get('success') }}
                </div>
            @endif

            @if ($workshops->count()>0)
            <div class="workshops">
                    @foreach ($workshops as $workshop)
                        <div class="workshop">
                            <div class="top">
                                <div class="icons">
                                    <div class="duration">
                                        <i class="fa-solid fa-clock-rotate-left"></i>
                                        <p>{{$workshop->duration}}</p>
                                    </div>
                                    <div class="maxPers">
                                        <i class="fa-solid fa-users"></i>
                                        <p>{{$workshop->max_pers}}</p>
                                    </div>
                                </div>
                                <div class="title">
                                    <div class="icon">
                                        <i class="fa-solid fa-chalkboard-user"></i>
                                    </div>
                                    <h2>{{Str::ucfirst($workshop->name)}}</h2>
                                </div>
                                <p class="description">{{$workshop->description}}</p>
                                <div class="info-container">
                                    <div class="info">
                                        <p>{{$workshop->location}}</p>
                                        <div class="divider"></div>
                                        <p>{{ date('H:m, d-m-Y', strtotime($workshop->date))}}</p>
                                        <div class="divider"></div>
                                        <p>aantal personen</p>
                                    </div>
                                </div>
                            </div>
                            <div class="blue-button">
                                @if (Auth::user()->role === 1)
                                    <button class="applications" data-applications="{{ $workshop->applications }}">Aanmeldingen</button>
                                    @if (count($workshop->applications) > 0)
                                        @foreach ($workshop->applications as $application)
                                            <p>Class: {{ $application->user->class->name }}</p>
                                        @endforeach
                                    @else
                                        <p>nope</p>
                                    @endif
                                @elseif (Auth::user()->role === 0)
                                    @if (count($workshop->applications) > 0)
                                        @foreach ($workshop->applications as $application)
                                            @if ($application->user_id === Auth::user()->id)
                                                <button class="signed-up"><i class="fa-solid fa-check"></i>Aangemeld</button>
                                            @else
                                                <form action="{{ route('signUp') }}" method="POST">
                                                    @csrf
                                                    <input type="hidden" name="workshopId" value="{{ $workshop->id }}">
                                                    <input type="hidden" name="userId" value="{{ Auth::user()->id }}">
                                                    <button class="sign-up" type="submit">Aanmelden</button>
                                                </form>
                                            @endif
                                        @endforeach
                                    @else
                                        <form action="{{ route('workshops') }}" method="POST">
                                            @csrf
                                            <input type="hidden" value="{{$workshop->id}}" name="workshopId" id="workshopId">
                                            <input type="hidden" value="{{Auth::user()->id}}" name="userId" id="userId">
                                            <button class="sign-up" type="submit">Aanmelden</button>
                                        </form>
                                    @endif
                                @endif
                            </div>
                        </div>       
                    @endforeach
                </div>
                @else 
                    <div class="no-workshops">
                        <p>Er zijn geen workshops gevonden</p>
                    </div>
                @endif
        </div>
        
        @if(Auth::user()->role === 1)
            <div class="add-workshop">
                <a href="/addWorkshop"><i class="fa-solid fa-plus"></i></a>
            </div>
        @endif
    </div>
    <div id="workshop-modal" class="d-none">
        <div class="applications-container">
            <div class="application">
                <p>Naam</p>
                <div class="divider"></div>
                <p>Klas</p>
            </div>
        </div>
    </div>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    {{-- <script>
        $(document).ready(function () {
            // Click event handler for loading workshop data
            $('.applications').click(function () {
                // Retrieve the data-workshop-id attribute
                var applicationsData = $(this).data('applications');
                var applications = JSON.parse(applicationsData);

                if (applicationsData.trim() !== '') {
                    // Display the modal with applications data
                    displayWorkshopModal(applicationsData);
                } else {
                    console.log('this one')
                    // Handle the case when data is empty or not valid JSON
                    $('#workshop-modal').removeClass('d-none');
                }
            });

            // Function to display the modal with applications data
            function displayWorkshopModal(applicationsData) {
                // Access and parse the JSON data
                var applications = JSON.parse(applicationsData);

                // Construct the HTML content for the modal using applications data
                var modalContent = '<h2>Workshop Applications</h2>';
                modalContent += '<ul>';
                applications.forEach(function (application) {
                    modalContent += '<li>';
                    modalContent += 'User ID: ' + application.user_id + '<br>';
                    modalContent += 'Additional Fields: ' + application.additional_fields; // Add more fields as needed
                    modalContent += '</li>';
                });
                modalContent += '</ul>';

                // Display the modal content
                $('#workshop-modal').html(modalContent);

                // Show the modal (you may need to implement your own modal display logic)
                $('#workshop-modal').show();
            }
        });
    </script> --}}
@endsection