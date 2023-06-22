<!doctype html>
<?php
$comadd = App\Company::find(1);
?>
<html>

<head>
    <meta charset="utf-8">
    <title>{{ config('app.title') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="shortcut icon" type="image/x-icon" href="{{ url('storage/avata') }}/{{ $comadd->logo }}">

    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css">
    <script src="js/jquery.1.10.2.min.js"></script>
    <script src="{{ asset('js/bootstrap.min.js') }}"></script>
    <script type="text/javascript" src="{{ asset('adminlte/js/all.js') }}"></script>
    <link rel="stylesheet" type="text/css" href="{{ asset('css/doc_style.css') }}">
    <link rel="stylesheet" type="text/css" href="{{ asset('adminlte/css/AdminLTE.min.css') }}">
    <link rel="stylesheet" type="text/css"
        href="{{ asset('adminlte/bower_components/font-awesome/css/font-awesome.min.css') }}">
</head>

<body>
    @yield('content')
</body>

</html>
