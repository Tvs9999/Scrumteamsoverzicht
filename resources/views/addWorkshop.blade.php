@extends('layout/app')

@section('content')
<div id="addWorkshop">
    <div class="content-header">
        <h1>Workshop toevoegen</h1>
    </div>
    @if(Session::has('success'))
    <div class="alert alert-success" role="alert">
        {{ Session::get('success') }}
    </div>
    @endif

    <div class="add-form">
        <form action="{{ route('addWorkshop') }}" method="POST">
            @csrf
            <div class="input">
                <label for="name">Naam</label>
                <input type="text" id="name" name="name" placeholder="Vul hier de naam van de workshop in...">
                @error('name')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input">
                <label for="description">Beschrijving</label>
                <textarea id="description" name="description" placeholder="Geef de workshop een beschrijving..."></textarea>
                @error('description')
                <div class="alert alert-danger">{{ $message }}</div>
                @enderror
            </div>
            <div class="input-row">
                <div class="input">
                    <label for="class">Klas</label>
                    <select id="class" name="class">
                        @foreach ($classNumbers as $class)
                        <option value="{{ $class->id }}">{{ $class->name }}</option>
                        @endforeach
                    </select>
                    @error('class')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input">
                    <label for="location">Locatie</label>
                    <input type="text" id="location" name="location" placeholder="Vul hier de locatie van de workshop in...">
                    @error('location')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="input-row">
                <div class="input">
                    <label for="datetime">Datum en tijd</label>
                    <input type="datetime-local" id="datetimePicker" name="datetime">
                    @error('datetime')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input">
                    <label for="duration">Duur</label>
                    <input type="text" id="duration" name="duration" placeholder="Vul hier de duur van de workshop in...">
                    @error('duration')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <div class="input-row">
                <div class="input">
                    <label for="minPers">Min. aanmeldingen</label>
                    <input type="number" id="minPers" name="minPers" placeholder="1">
                    @error('minPers')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <div class="input">
                    <label for="maxPers">Max. aanmeldingen</label>
                    <input type="number" id="maxPers" name="maxPers" placeholder="2">
                    @error('maxPers')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
            </div>
            <button type="submit">Workshop aanmaken</button>
        </form>
    </div>
</div>
@endsection

<script>
document.addEventListener("DOMContentLoaded", function() {
  // Create a date object for the current time with the UTC+2 offset
  const nowUTCPlus2 = new Date();
  nowUTCPlus2.setHours(nowUTCPlus2.getHours() + 2);

  // Convert the UTC+2 time to an ISO string without milliseconds
  const currentDateTimeUTCPlus2ISOString = nowUTCPlus2.toISOString().slice(0, 16);

  // Set the min and value attributes of the input to the current UTC+2 time
  document.getElementById("datetimePicker").min = currentDateTimeUTCPlus2ISOString;
  document.getElementById("datetimePicker").value = currentDateTimeUTCPlus2ISOString;
});
</script>