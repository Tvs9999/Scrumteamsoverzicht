@extends('layout/app')

@section('content')
<div id="register">
    <div class="content-header">
        <h1>Gebruiker toevoegen</h1>
    </div>
    <div class="register">
        @if(Session::has('success'))
        <div class="alert alert-success" role="alert">
            {{ Session::get('success') }}
        </div>
        @endif
        <form action="{{ route('register') }}" method="POST">
            @csrf
            <div class="input">
                <label for="email">Email address</label>
                <input type="email" name="email" id="email" placeholder="Vul hier het e-mailadres in..." required>
            </div>
            <div class="input">
                <label for="rol">Rol</label>
                <select name="rol" id="rol" required>
                    <option value="0">Student</option>
                    <option value="1">Docent</option>
                </select>
            </div>
            <div class="input">
                <label for="klas">Klas</label>
                <select name="klas" id="klas" required>
                    @foreach ($classNumbers as $class)
                      <option value="{{ $class }}">{{ $class }}</option>
                    @endforeach
                    <option value="new">Nieuwe Klas</option>
                </select>
            </div>
            <div class="input d-none" id="new-class-input">
                <label for="new_class_number">Nieuw Klasnummer</label>
                <input type="text" name="new_class_number" id="new_class_number" placeholder="Enter new class number">
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

    const klas = $('#klas');
    const klasInput = $('#new-class-input');

    $(document).ready(function () {
        klas.on("change", function () {
            if (klas.val() === "new") {
                klasInput.removeClass('d-none');
            } else {
                klasInput.addClass('d-none');
            }
        })
    })
</script>
@endsection