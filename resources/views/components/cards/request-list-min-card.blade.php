<article class="p-6 bg-white rounded-lg border border-gray-200 shadow-md dark:bg-gray-800 dark:border-gray-700">
    <div class="flex justify-between items-center mb-5 text-gray-500">
        <span class="   inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-1.5 rounded-full dark:bg-green-900 dark:text-green-300">
            <span class=" w-2 h-2 me-1 bg-green-500 rounded-full"></span>
            {{  __("request_status.".$request->status)}}
        </span>

        <span class="text-sm">{{ $request->created_at->format("Y-m-d") }}</span>
    </div>
    <h2 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white"><span> {{ $request->requests->name  ?? 'name' }} </span></h2>
    <p class="mb-5 font-light text-gray-500 dark:text-gray-400">

        {{ $request->note ?? ' '}}

    </p>
    <div class="flex justify-between items-center">

        <a href="({{Route("user.requests.create")}})" class="inline-flex items-center font-medium text-primary-600 dark:text-primary-500 hover:underline">
         {{__("string.Show request")}}
        </a>
    </div>
</article>
