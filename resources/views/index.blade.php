<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Kaltura Home Assignment (BM)">
    <meta name="author" content="Barak Michaeli">
    <title>Kaltura | Virtual Events</title>
    @if(parse_url(url('/'), PHP_URL_SCHEME) == 'HTTPS')
        <link rel="stylesheet" href="{{ secure_asset('css/app.css') }}">
        <link rel="stylesheet" href="{{ secure_asset('vendor/bootstrap/css/bootstrap.css') }}">
    @else
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <link href="{{ asset('vendor/bootstrap/css/bootstrap.css') }}" rel="stylesheet">
    @endif
    <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
</head>
<body>
    <div id="app">
        <App/>
    </div>
    <script src="{{ asset('js/app.js') }}"></script>
</body>
</html>