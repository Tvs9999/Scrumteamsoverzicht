<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    @vite('resources/scss/app.scss', 'resources/css/app.css', 'resources/app/app.js')
    <title>Scrumteamsoverzicht</title>
</head>
<body>
    
<div id="activate-account">
    <div class="overlay">
        @if(Session::has('success'))
            <div class="alert alert-success" role="alert">
                {{ Session::get('success') }}
            </div>
        @endif
        <div class="logo-container">
            <div class="logo">
                <h2>Scrum<br>teams<br>overzicht</h2>
                <div class="left"></div>
                <div class="bottom"></div>
            </div>
        </div>
        <div class="activate">
            <h1>Account afmaken</h1>

            <form action="" method="POST">
                @csrf
                <div class="input-row">
                    <div class="input">
                        <label for="first_name">Voornaam</label>
                        <input type="text" name="first_name" id="first_name" placeholder="Voornaam" minlength="2">
                        @error('first_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                    <div class="input">
                        <label for="last_name">Achternaam</label>
                        <input type="text" name="last_name" id="last_name" placeholder="Achternaam" minlength="2">
                        @error('last_name')
                        <div class="alert alert-danger">{{ $message }}</div>
                        @enderror
                    </div>
                </div>
                <div class="input">
                    <label for="password">Wachtwoord</label>
                    <input type="password" name="password" id="password" placeholder="Vul hier je wachtwoord in...">
                    @error('password')
                    <div class="alert alert-danger">{{ $message }}</div>
                    @enderror
                </div>
                <button>Account activeren</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>
