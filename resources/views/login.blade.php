<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    <title>Login</title>
    @vite(['resources/scss/app.scss', 'resources/css/app.css', 'resources/js/app.js'])
</head>
<body>
<div id="login">
    <div class="overlay">
        <div class="login-content">
            <div class="logo-container">
                <div class="logo">
                    <h1>Scrum<br>teams<br>overzicht</h1>
                    <div class="left"></div>
                    <div class="bottom"></div>
                </div>
            </div>
            <form action="{{ route('login.post') }}" method="POST">
                @csrf
                @if(session('error'))
                    <div class="alert alert-danger">
                        {{ session('error') }}
                    </div>
                @endif
                <div class="input">
                    <label for="email">E-mailadres</label>
                    <input type="email" name="email" id="email" placeholder="Vul hier je e-mailadres in..." required>
                </div>
                <div class="input">
                    <label for="password">Wachtwoord</label>
                    <input type="password" name="password" id="password" minlength="8" maxlength="20" placeholder="Vul hier je wachtwoord in..." required>
                </div>
                <button type="submit">Inloggen</button>
            </form>
        </div>
    </div>
</div>
</body>
</html>