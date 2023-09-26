<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-KK94CHFLLe+nY2dmCWGMq91rCGa5gtU4mk92HdvYe+M/SXH301p5ILy+dN9+nJOZ" crossorigin="anonymous">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ENjdO4Dr2bkBIFxQpeoTz1HIcje39Wm4jDKdf19U8gI4ddQ3GYNS7NTKfAdVQSZe" crossorigin="anonymous"></script>
    @vite('resources/scss/app.scss', 'resources/css/app.css', 'resources/app/app.js')
    <title>Scrumteamsoverzicht</title>
</head>
<body>
    <div class="page-container">
        <div id="sidebar">
            <ul>
                <li class="logo"></li>
                <li class="link"><a href=""><i class="fa-solid fa-table-columns"></i></a></li>
                <li class="link"><a href=""><i class="fa-solid fa-chalkboard-user"></i></a></li>
                <li class="link"><a href=""><i class="fa-solid fa-user-group"></i></a></li>
                <li class="link"><a href=""><i class="fa-solid fa-user"></i></a></li>
            </ul>
            <a class="logout" href=""><i class="fa-solid fa-right-from-bracket"></i></a>
        </div>
        <main>
            @yield('content')
        </main>
    </div>
</body>
</html>