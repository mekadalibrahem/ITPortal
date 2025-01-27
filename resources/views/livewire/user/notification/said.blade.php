<div class="   h-screen  overflow-auto  ">

    <h2 class="mb-2 p-4 text-lg font-semibold  border-b border-e text-gray-900 dark:text-white">
        {{ __('string.All notifications') }}
    </h2>
    <ul class="max-w-md space-y-1 text-gray-500  list-none list-inside dark:text-gray-400">
        @forelse ($notify_list as $notify)
            <li class=" p-4 m-4 border-b bg-white rounded-lg  dark:bg-gray-700 " wire:key="{{$notify->id}}">

                <div class="flex justify-between items-center mb-5 text-gray-500">

                    @if (!$notify->is_read())
                        <span
                            class="   inline-flex items-center bg-green-100 text-green-800 text-xs font-medium px-2.5 py-1.5 rounded-full dark:bg-green-900 dark:text-green-300">
                            <span class=" w-2 h-2 me-1 bg-green-500 rounded-full"></span>
                            {{ __('string.new notify') }}
                        </span>
                    @endif

                    <span class="text-sm">{{ $notify->date() }}</span>




                </div>
                <form action="">
                    @csrf
                    <h2 class="mb-2 text-2xl font-bold tracking-tight text-gray-900 dark:text-white">
                        <button  type="button"  wire:click="show({{$notify->id}})">
                            {{ Str::limit($notify->content ,15 ) }}

                        </button>
                    </h2>
                </form>

                <p class="mb-5 font-light text-gray-500 dark:text-gray-400">

                    {{ $notify->sender()->email }}
                </p>


            </li>
        @empty
        @endforelse

    </ul>

</div>
