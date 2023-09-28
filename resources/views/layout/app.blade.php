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
    @vite(['resources/scss/app.scss', 'resources/css/app.css', 'resources/js/app.js'])
    <title>Scrumteamsoverzicht</title>
</head>
<body>
    <div class="page-container">
        <div id="sidebar" class="">
            <p class="scrumteamsoverzicht">Scrum<br>teams<br>overzicht</p>
            <div>
                <div class="logo" id="logo">
                    <div class="top"></div>
                    <div class="right"></div>
                    <div class="bottom"></div>
                    <div class="left"></div>
                </div>
                <ul>
                    <li><a class="link" href="/dashboard"><i class="fa-solid fa-table-columns"></i><span>Dashboard</span></a></li>
                    <li><a class="link" href="/workshops"><i class="fa-solid fa-chalkboard-user"></i><span>Workshops</span></a></li>
                    <li><a class="link" href="/addScrumteam"><i class="fa-solid fa-user-group"></i><span>Scrumteams</span></a></li>
                    <li><a class="link" href="/users"><i class="fa-solid fa-user"></i><span>Gebruikers</span></a></li>
                </ul>
            </div>
            <div class="logout">
                <a class="link" href="{{ route('logout') }}"><i class="fa-solid fa-right-from-bracket"></i><span>Uitloggen</span></a>
            </div>
        </div>
        <main>
            @yield('content')
        </main>
    </div>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script>
        $(document).ready(function(){
           // Get the current path (URL without the domain)
            var currentPath = window.location.pathname;

            // Loop through each navigation link
            $('.link').each(function() {
                var linkURL = $(this).attr('href');

                // Check if the current path matches the link's href
                if (currentPath === linkURL) {
                    // Add the "active" class to the matching link
                    $(this).addClass('active');
                }
            });

            $('.logo').click(function(){
                $('#sidebar').toggleClass("active");
            });
        })
    </script>
    
</body>
</html>