<div class="m-5 col-span-2 h-screen {{ $hidden ? 'hidden' : '' }}">

    @if (!$hidden)
    
    <article
        class="p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-700 dark:border-gray-900">
        <div class="flex justify-between items-center mb-5 text-gray-500">

            <span class="text-sm">{{ $notify->date()}}</span>
        </div>
        <h2 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><a href="#">

               {{$notify->content}}
            </a></h2>
        <p class="mb-5 font-light text-gray-500 dark:text-gray-400">
            رسالة من : {{$notify->sender()->email}}
        </p>
    </article>

    @endif
</div>
