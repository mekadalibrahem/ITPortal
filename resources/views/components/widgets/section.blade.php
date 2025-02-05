     @props(['title' ])
     <section class="bg-slate-200/75 sm:mx-0   md:mx-auto  px-4  mt-8 rounded-lg  dark:bg-slate-800">
        <div class="max-w-6xl px-2 py-8 mx-auto lg:py-16">
            <h2 class="mb-4 text-xl font-bold text-slate-950 dark:text-white">
               {{ $title }}
           </h2>
           {{
                $slot
           }}
        </div>
    </section>
