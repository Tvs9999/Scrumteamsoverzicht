@extends('layout/app')

@section('content')
<div id="register">
    <div class="content-header">
        <h1>Gebruiker toevoegen</h1>
    </div>
    <div class="register">
        @if(Session::has('success'))
        <div class="success-message" role="alert">
            {{ Session::get('success') }}
        </div>
        @endif
        @if ($errors->any())
            <div class="error-message">
                @foreach ($errors->all() as $error)
                    <p>{{ $error }}</p>
                @endforeach
            </div>
        @endif
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="input">
                <label for="email">E-mailadres</label>
                <input type="email" name="email" id="email" placeholder="Vul hier het e-mailadres in..." maxlength="255" required>
            </div>
            @error('email')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="input">
                <label for="rol">Rol</label>
                <select name="rol" id="rol" required>
                    <option value="0">Student</option>
                    <option value="1">Docent</option>
                </select>
            </div>
            @error('rol')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="input" id="klasSelect">
                <label for="klas">Klas</label>
                <select name="klas" id="klas" required>
                    @foreach ($classNumbers as $class)
                      <option value="{{ $class->id }}">{{ $class->name }}</option>
                    @endforeach
                    <option value="new">Naam nieuwe klas</option>
                </select>
            </div>
            @error('klas')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            @error('new_class_number')
            <div class="alert alert-danger">{{ $message }}</div>
            @enderror
            <div class="input d-none" id="new-class-input">
                <label for="new_class_number">Nieuwe klas</label>
                <input type="text" name="new_class_number" id="new_class_number" placeholder="Voer naam klas in" maxlength="255">
            </div>
            
            <button>Account aanmaken</button>
        </form>
    </div>
</div>
<script>
    // document.addEventListener("DOMContentLoaded", function() {
    //     klasSelect.addEventListener("change", function() {
    //         if (klasSelect.value === "new") {
    //             newClassInput.removeClass('d-none');
    //         } else {
    //             newClassInput.addClass('d-none');
    //         }
    //     });
    // });

    const rol = $('#rol');
    const klasSelect = $('#klasSelect');
    const klas = $('#klas');
    const klasInput = $('#new-class-input');
    const newClassNumberInput = $('#new_class_number')

    $(document).ready(function () {
        if(klas.val() == "new"){
            klasInput.removeClass('d-none');
            newClassNumberInput.attr('required', true);
        }

    rol.on("change", function () {
        if (rol.val() == 1){
            klasSelect.addClass('d-none');
            klasInput.addClass('d-none');
            newClassNumberInput.removeAttr('required'); // Remove the "required" attribute
        } else {
            klasSelect.removeClass('d-none');

            if (klas.val() == "new"){
                klasInput.removeClass('d-none');
                newClassNumberInput.attr('required', true); // Add the "required" attribute
            }
        }
    })

    klas.on("change", function () {
        if (klas.val() === "new") {
            klasInput.removeClass('d-none');
            newClassNumberInput.attr('required', true); // Add the "required" attribute
        } else {
            klasInput.addClass('d-none');
            newClassNumberInput.removeAttr('required'); // Remove the "required" attribute
        }
    })
})
</script>
@endsection