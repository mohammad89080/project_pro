<!-- Title -->
<title>@yield("title")</title>

<!-- Favicon -->
<link rel="shortcut icon" href="{{ URL::asset('assets/images/favicon.ico') }}" type="image/x-icon" />

<!-- Font -->

@yield('css')
<!--- Style css -->



<script src="{{ URL::asset('js/attendance.js') }}"></script>
<!--- Style css -->
@if (App::getLocale() == 'en')
    <link href="{{ URL::asset('assets/css/ltr.css') }}" rel="stylesheet">

@else
    <link href="{{ URL::asset('assets/css/style.css') }}" rel="stylesheet">
    <link href="{{ URL::asset('assets/css/rtl.css') }}" rel="stylesheet">

    <style>

        @import url('https://fonts.googleapis.com/css2?family=Cairo+Play:wght@500&family=Cairo:wght@500&family=Markazi+Text&display=swap');
        body{
            font-family: 'Cairo', sans-serif;
            font-family: 'Cairo Play', sans-serif;
            font-family: 'Markazi Text', serif;
            font-size: 16px;
        }

    </style>
@endif

