     @props(['title' ])
     <section class="bg-white sm:mx-0   md:mx-auto  px-4  mt-8 rounded-lg  dark:bg-gray-900">
        <div class="max-w-6xl px-2 py-8 mx-auto lg:py-16">
            <h2 class="mb-4 text-xl font-bold text-gray-900 dark:text-white">
               {{ $title }}
           </h2>
           {{
                $slot
           }}
        </div>
    </section>
