@extends('layout/app')

@section('content')
    <div id="addScrumteam">
        <div class="content-header">
            <h1>Scrumteam toevoegen</h1>
        </div>
        <div class="add-form">
            <form action="addscrumteampost" method="POST">
                <div class="input">
                    <label for="name">Naam</label>
                    <input type="text" id="name" name="name" placeholder="Vul hier het scrumteam in" required>
                </div>
                <div class="input-row">
                    <div class="input">
                        <label for="class">Klas</label>
                        <select name="klas" id="klas" required>
                            <option value="" disabled selected>Selecteer een klas</option>
                            @foreach ($classes as $class)
                            <option value="{{$class->id}}">{{$class->name}}</option>
                            @endforeach
                            <option value="new">Nieuwe Klas</option>
                        </select>
                    </div>
                    <div class="mb-3" id="new-class-input" style="display: none;">
                        <label for="new_class_number">Nieuw Klas</label>
                        <input type="text" name="new_class"id="new_class" placeholder="Vul hier een nieuwe klas">
                    </div>
                    <div class="input">
                        <label for="students">Leerlingen</label>
                        <select id="students" name="students">
                            @foreach ($users as $user)
                            <option value="{{$user->id}}">{{$user->firstname}} {{$user->lastname}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <button type="submit">Scrumteam aanmaken</button>
            </form>
        </div>
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            const klasSelect = document.getElementById("klas");
            const newClassInput = document.getElementById("new-class-input");

            klasSelect.addEventListener("change", function() {
                if (klasSelect.value === "new") {
                    newClassInput.style.display = "block";
                } else {
                    newClassInput.style.display = "none";
                }
            });
        });
    </script>
    </div>
@endsection