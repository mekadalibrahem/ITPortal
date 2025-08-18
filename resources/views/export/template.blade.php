<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Request Document</title>
    {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> --}}
    {{-- <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}"> --}}
    @vite('resources/css/bootstrap.min.css');
    {{-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.7/dist/css/bootstrap.min.css"> --}}
    @if ($cssContent)
        <style>
            {{ $cssContent }}
        </style>
    @endif
</head>

<body>
    {!! $htmlContent !!}
    {{-- <script src="{{ asset('js/bootstrap.min.js') }}"></script> --}}
</body>

</html>
