<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
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