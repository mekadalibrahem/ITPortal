<header class="flex flex-wrap sm:justify-start sm:flex-nowrap w-full bg-white text-sm py-3 dark:bg-neutral-800">
    <nav class="max-w-[85rem] w-full mx-auto px-4 flex flex-wrap basis-full items-center justify-between">
      <a class="sm:order-1 flex-none text-xl font-semibold dark:text-white focus:outline-none focus:opacity-80" href="#"> ITPortal </a>

     <div class="sm:order-3 flex items-center gap-x-2">
       @auth
       <x-button status='primary' data-drawer-target="default-sidebar" data-drawer-toggle="default-sidebar"
       aria-controls="default-sidebar" type="button" class="inline-flex sm:hidden">
       <span class="sr-only">Open main menu</span>
       <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
           <path fill-rule="evenodd"
               d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z"
               clip-rule="evenodd"></path>
       </svg>
       <svg class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20"
           xmlns="http://www.w3.org/2000/svg">
           <path fill-rule="evenodd"
               d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
               clip-rule="evenodd"></path>
       </svg>
   </x-button>
       {{-- <button type="button" class="sm:hidden hs-collapse-toggle relative size-7 flex justify-center items-center gap-x-2 rounded-lg border border-gray-200 bg-white text-gray-800 shadow-sm hover:bg-gray-50 focus:outline-none focus:bg-gray-50 disabled:opacity-50 disabled:pointer-events-none dark:bg-transparent dark:border-neutral-700 dark:text-white dark:hover:bg-white/10 dark:focus:bg-white/10" id="hs-navbar-alignment-collapse" aria-expanded="false" aria-controls="hs-navbar-alignment" aria-label="Toggle navigation" data-hs-collapse="#hs-navbar-alignment">
        <svg class="hs-collapse-open:hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="3" x2="21" y1="6" y2="6"/><line x1="3" x2="21" y1="12" y2="12"/><line x1="3" x2="21" y1="18" y2="18"/></svg>
        <svg class="hs-collapse-open:block hidden shrink-0 size-4" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M18 6 6 18"/><path d="m6 6 12 12"/></svg>
        <span class="sr-only">Toggle</span>
      </button> --}}
       @endauth
       @auth
       <form action="{{ Route('logout_handler') }}" method="GET" class="w-full">
           @csrf
           <x-button.danger type="submit">{{ __('string.logout') }}</x-button.danger>
       </form>
   @endauth

   @guest
       <div class="me-2  w-full">
           <x-switch-lang />
       </div>
       <div class=" flex items-center gap-1 w-full ">

           <form action="{{ Route('login') }}" method="GET" class="w-full">
               @csrf
               <x-button status="default"  size="sm" type="submit"> {{ __('string.login') }} </x-button>
           </form>

           <form action="{{ Route('register') }}" method="GET">
               @csrf
               <x-button status="primary"  size="sm" type="submit"> {{ __('string.register') }} </x-button>
           </form>
       </div>
   @endguest





      </div>
      <div id="hs-navbar-alignment" class="hs-collapse hidden overflow-hidden transition-all duration-300 basis-full grow sm:grow-0 sm:basis-auto sm:block sm:order-2" aria-labelledby="hs-navbar-alignment-collapse">

      </div>
    </nav>
  </header>
