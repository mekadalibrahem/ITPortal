<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>
        {{ $title ?? 'page' }}-{{ Config::get('app.name') }}
    </title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <livewire:styles />


</head>
@php

    $dir = app()->getLocale() === 'ar' ? 'rtl' : 'ltr';

@endphp

<body dir="{{ $dir }}">
    <x-layouts.nav />
     <x-toaster-hub />
    <div class="antialiased  bg-slate-50 dark:text-white  dark:bg-slate-950">
        <main class=" sm:p-4  md:p-10   bg-slate-50 items-center h-screen overflow-auto pt-10 dark:bg-slate-950">
            {{ $slot }}
        </main>
    </div>


    <livewire:scripts />



</body>

</html>
