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
    @if (request()->route()->getName() !== 'tickets.menu')
        <nav>
{{--            TODO: make buttons clickable, not text in it--}}
            <a href="#" onclick="history.back()" >Back</a>
            <a href="{{ route('tickets.menu') }}" >Menu</a>
        </nav>
    @endif

    @yield('content')
</main>

</body>
</html>
