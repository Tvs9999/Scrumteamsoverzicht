@extends('layout/app')

@section('content')
    <div id="addScrumteam">
        <div class="content-header">
            <h1>Scrumteam toevoegen</h1>
        </div>
        <div class="add-form">
            <form action="">
                <div class="input">
                    <label for="name">Naam</label>
                    <input type="text" id="name" name="name" placeholder="Vul hier de naam van het scrumteam in...">
                </div>
                <div class="input-row">
                    <div class="input">
                        <label for="class">Klas</label>
                        <select id="class" name="class">
                            <option value="">Klas</option>
                        </select>
                    </div>
                    <div class="input">
                        <label for="students">Leerlingen</label>
                        <input type="" id="students" name="student" placeholder="Alle studenten in de vak   ">
                    </div>
                </div>
                <button type="submit">Scrumteam aanmaken</button>
            </form>
        </div>
    </div>
@endsection