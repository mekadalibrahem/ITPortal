<!DOCTYPE html>
<html >
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        {{ $title ?? 'page' }}-{{ Config::get('app.name') }}
    </title>

    @vite(['resources/css/app.css','resources/js/app.js'])

</head>
@php

    $dir = (app()->getLocale() === 'ar' ? 'rtl' : "ltr")

@endphp
<body dir="{{$dir}}" >
    <x-layouts.nav />

    <div class="antialiased  bg-gray-50 dark:text-white  dark:bg-gray-400">
        <main class=" m-auto h-screen overflow-auto pt-10" >
            {{
                $slot
            }}
        </main>
    </div>



</body>
</html>
