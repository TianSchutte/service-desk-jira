<!doctype html>
<html lang="en">
<head>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link rel="stylesheet" href="{{ asset('vendor/courier/css/jira-service-desk.css') }}">
    {{--    TODO: this stylesheet link must be updated, i think, to be dynamic?--}}
    {{--    TODO: also must run php artisan vendor:publish --tag=public --force --}}
    <title>Document</title>

</head>
<body>
<main>

    <div class="nav-container">
        <nav>
            @if (request()->route()->getName() !== 'tickets.menu')
                <a href="#" onclick="history.back()">Back</a>
            @endif

            <p style="color: black">Service Desk</p>

            @if (request()->route()->getName() !== 'tickets.menu')
                <a href="{{ route('tickets.menu') }}">Menu</a>
            @endif
        </nav>
    </div>


    <div class="base-container">
        @yield('content')
    </div>
</main>

</body>
</html>
