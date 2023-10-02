@extends('layout/app')

@section('content')
    <div id="workshops">

        @if(Session::has('success'))
            <div class="success-message" id="success-message" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif
        <div class="content-header">
            <h1>Workshops</h1>
        </div>
        <div class="workshops-container">


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

                                    @if (count($workshop->applications) > 0)
                                        <button class="see-applications" data-workshop-id="{{ $workshop->id }}">Aanmeldingen</button>    
                                    @else
                                        <button class="no-applications"><i class="fa-solid fa-xmark"></i> Geen aanmeldingen</button>
                                    @endif
                                @elseif (Auth::user()->role === 0)
                                    @if (count($workshop->applications) > 0)
                                        @if (count($workshop->applications) == $workshop->max_pers)
                                            <button class="full">Vol</button>
                                        @else
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
                                        @endif
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
            <div class="modal-title"></div>
            <div class="close-applications"><i class="fa-solid fa-xmark"></i></div>
            <div class="applications">
                
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            $('.see-applications').click(function () {
                var workshopId = $(this).data('workshop-id');

                $.ajax({
                    url: '/workshops/applications/' + workshopId,
                    method: 'GET',
                    dataType: 'json',
                    success: function (response) {
                        if (response.applications.length > 0) {
                            displayWorkshopModal(response);
                        } else {
                            console.log('No applications found');
                            // Handle the case when no applications are found
                        }
                    },
                    error: function (error) {
                        console.error('Error:', error);
                        // Handle any errors that occur during the AJAX request
                    }
                });
            });


            // Function to display the modal with applications data
            function displayWorkshopModal(applicationsData) {
                // Access and parse the JSON data

                // Construct the HTML content for the modal using applications data
                var modalHeader = '<h3>' + applicationsData.workshop_name + ' | Aanmeldingen</h3>';
                var modalContent = '';
                var i = 0;
                applicationsData.applications.forEach(function (application) {
                    if (i > 0){
                        modalContent += '<div class="application-divider"></div>';
                    };
                    modalContent += '<div class="application">';
                    modalContent += '<p>' + application.first_name + ' ' + application.last_name + '</p>';
                    modalContent += '<div class="info-divider"></div>';
                    modalContent += '<p class="class">' + application.class_name + '</p>';
                    modalContent += '</div>';
                    i++
                });

                // Display the modal content
                $('.modal-title').html(modalHeader);
                $('.applications').html(modalContent);

                // Show the modal (you may need to implement your own modal display logic)
                $('#workshop-modal').removeClass('d-none');
            }

            $('.close-applications').click(function (){
                $('#workshop-modal').addClass('d-none')
            })
        });
    </script>
@endsection