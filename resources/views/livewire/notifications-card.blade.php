<article class="p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
    <div class="flex justify-between items-center mb-5 text-gray-500">
        <button wire:click='markread'
            class="bg-primary-200 text-primary-800 text-xs font-medium inline-flex items-center px-2.5 py-0.5 rounded dark:bg-primary-200 dark:text-primary-800">
            {{__("string.Mark as read")}}
        </button>
        <span class="text-sm">{{ $notification->date() }}</span>
    </div>
    <h2 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><a href="#"> {{ $notification->content }} </a></h2>
    <p class="mb-5 font-light text-gray-500 dark:text-gray-400">
        {{-- Static websites are now used to bootstrap lots of websites and are becoming the basis for a variety of tools that even influence both web designers and developers influence both web designers and developers. --}}
        {{ $notification->note ?? ' '}}


    </p>
    <div class="flex justify-between items-center">

        <a href="#" class="inline-flex items-center font-medium text-primary-600 dark:text-primary-500 hover:underline">
         {{ __("string.Show notifications")}}
        </a>
    </div>
</article>


{{-- notification --}}
