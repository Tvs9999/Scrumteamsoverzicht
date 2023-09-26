@extends('layout/app')

@section('content')
    <div id="addWorkshop">
        <div class="content-header">
            <h1>Workshop toevoegen</h1>
        </div>
        <div class="add-form">
            <form action="">
                <div class="input">
                    <label for="name">Naam</label>
                    <input type="text" id="name" name="name" placeholder="Vul hier de naam van de workshop in...">
                </div>
                <div class="input">
                    <label for="description">Beschrijving</label>
                    <textarea id="description" name="description" placeholder="Geef de workshop een beschrijving..."></textarea>
                </div>
                <div class="input-row">
                    <div class="input">
                        <label for="class">Klas</label>
                        <select id="class" name="class">
                            <option value="">Klas 1</option>
                        </select>
                    </div>
                    <div class="input">
                        <label for="location">Locatie</label>
                        <input type="text" id="location" name="location" placeholder="Vul hier de locatie van de workshop in...">
                    </div>
                </div>
                <div class="input-row">
                    <div class="input">
                        <label for="datetime">Datum en tijd</label>
                        <input type="datetime-local" id="datetime" name="datetime">
                    </div>
                    <div class="input">
                        <label for="duration">Duur</label>
                        <input type="text" id="duration" name="duration" placeholder="Vul hier de duur van de workshop in...">
                    </div>
                </div>
                <div class="input-row">
                    <div class="input">
                        <label for="minPers">Min. aanmeldingen</label>
                        <input type="number" id="minPers" name="minPers" placeholder="1">
                    </div>
                    <div class="input">
                        <label for="maxPers">Max. aanmeldingen</label>
                        <input type="number" id="maxPers" name="maxPers" placeholder="2">
                    </div>
                </div>
                <button type="submit">Workshop aanmaken</button>
            </form>
        </div>
    </div>
@endsection