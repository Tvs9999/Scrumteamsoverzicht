<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <!-- Load Bootstrap 5 CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/css/bootstrap-grid.min.css" integrity="sha512-ZuRTqfQ3jNAKvJskDAU/hxbX1w25g41bANOVd1Co6GahIe2XjM6uVZ9dh0Nt3KFCOA061amfF2VeL60aJXdwwQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Load Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" integrity="sha512-z3gLpd7yknf1YoNbCzqRKc4qyor8gaKU1qmn+CShxbuBusANI9QpRohGBreCFkKxLhei6S9CQXFEbbKuqLg0DA==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <!-- Load jQuery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Load Bootstrap 5 JavaScript (including Popper.js) -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/5.3.2/js/bootstrap.min.js" integrity="sha512-WW8/jxkELe2CAiE4LvQfwm1rajOS8PHasCCx+knHG0gBHt8EXxS6T6tJRTGuDQVnluuAvMxWF4j8SNFDKceLFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <!-- Load your own assets (Vite) -->
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
                    @if (Auth::user()->role === 1)
                        <li><a class="link" href="/scrumteams"><i class="fa-solid fa-user-group"></i><span>Scrumteams</span></a></li>
                        <li><a class="link" href="/gebruikers"><i class="fa-solid fa-user"></i><span>Gebruikers</span></a></li>
                    @endif
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