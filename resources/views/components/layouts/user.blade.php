<!DOCTYPE html>
<html lang=>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $title ?? 'page' }}
        - {{ Config::get('app.name') }}</title>

    @vite(['resources/css/app.css','resources/js/app.js'])


</head>

<body dir="rtl">
    <div class="antialiased overflow-auto bg-gray-50 dark:bg-gray-700">


        <main >

            {{
                $slot
            }}
        </main>
    </div>



</body>
</html>
