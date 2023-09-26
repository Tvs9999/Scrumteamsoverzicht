<!doctype html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Gebruiker aanmaken - Registratiepagina</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
</head>

<body>
    <div class="row justify-content-center mt-5">
        <div class="col-lg-4">
            <div class="card">
                <div class="card-header">
                    <h1 class="card-title">Gebruiker toevoegen</h1>
                </div>
                <div class="card-body">
                    @if(Session::has('success'))
                    <div class="alert alert-success" role="alert">
                        {{ Session::get('success') }}
                    </div>
                    @endif
                    <form action="{{ route('register') }}" method="POST">
                        @csrf
                        <div class="mb-3">
                            <label for="email" class="form-label">Email address</label>
                            <input type="email" name="email" class="form-control" id="email" placeholder="name@example.com" required>
                        </div>
                        <div class="mb-3">
                            <label for="rol" class="form-label">Rol</label>
                            <select name="rol" class="form-control" id="rol" required>
                                <option value="" disabled selected>Selecteer een rol</option>
                                <option value="0">Student</option>
                                <option value="1">Docent</option>
                            </select>
                        </div>
                        <div class="mb-3">
                            <label for="klas" class="form-label">Klas</label>
                            <select name="klas" class="form-control" id="klas" required>
                                <option value="" disabled selected>Selecteer een klas</option>
                                @foreach ($classNumbers as $class)
                                <option value="{{ $class }}">{{ $class }}</option>
                                @endforeach
                                <option value="new">Nieuwe Klas</option>
                            </select>
                        </div>
                        <div class="mb-3" id="new-class-input" style="display: none;">
                            <label for="new_class_number" class="form-label">Nieuw Klasnummer</label>
                            <input type="text" name="new_class_number" class="form-control" id="new_class_number" placeholder="Enter new class number">
                        </div>
                        <div class="mb-3">
                            <div class="d-grid">
                                <button class="btn btn-primary">Account aanmaken</button>
                            </div>
                        </div>
                    </form>

                </div>
            </div>
        </div>
    </div>
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

</body>

</html>