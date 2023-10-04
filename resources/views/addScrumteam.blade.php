@extends('layout/app')

@section('content')
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <div id="addWorkshop">
        <div class="content-header">
            <h1>Scrumteam toevoegen</h1>
        </div>
        @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif

        @error('name')
            <div class="alert alert-danger">{{ $message }}</div>
        @enderror
        <div class="add-form">
        <form action="{{ route('addScrumteam.post') }}" method="POST">
                @csrf
                <div class="input">
                    <label for="name">Naam</label>
                    <input type="text" id="name" name="name" placeholder="Vul hier het scrumteam in" minlength="4" required>
                </div>
                <div class="input-row">
                    <div class="input">
                        <label for="class">Klas</label>
                        <select name="class_id" id="klas" onchange="loadStudents(this.value)" required>
                            @foreach ($classes as $class)
                            <option value="{{$class->id}}">{{$class->name}}</option>
                            @endforeach
                        </select>
                    </div></div>
                    @error('class_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    <input hidden value="{{$scrumteamid}}" name="team_id">
                    <div class="input">
                        <label for="students">Leerlingen</label>
                    </div>
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#exampleModal">
                        Voeg leerlingen toe
                    </button>
                    @error('user_id')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                    
                    <!-- Modal -->
                    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                            <div class="modal-header">
                                <h5 class="modal-title" id="exampleModalLabel" style="color:black;">Voeg leerlingen toe</h5>
                            </div>
                            <div class="modal-body">
                                <input name="findstudent" placeholder="Zoek een leerling"><br><br>
                                @foreach ($users as $user)
                                <input type="checkbox" value="{{$user->id}}" name="user_id[]"> {{$user->firstname}} {{$user->lastname}}<br>
                                @endforeach
                            </div>
                            <div class="modal-footer">
                                <button type="button" data-dismiss="modal">Leerling Selecteren</button>
                            </div>
                            </div>
                        </div>
                    </div>
                    <!-- End Modal-->
                    </div>
                    <button type="submit" class="btn btn-primary">Scrumteam aanmaken</button>
                </div>
            </form>
            
        </div>
    </div>
@endsection


<script>
    function loadStudents(classId) {
        // Send an AJAX request to fetch students based on classId
        $.ajax({
            type: 'GET',
            url: '/fetch-students/' + classId, // Replace with the actual URL to fetch students
            success: function(data) {
                // Update the modal body with the fetched student data
                $('.modal-body').html(data);
            }
        });
    }
</script>