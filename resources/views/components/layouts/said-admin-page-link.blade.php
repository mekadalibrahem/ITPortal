<ul class="flex flex-col space-y-1">
    <x-widgets.sidebar-link href="{{Route('admin.staticties')}}">
        {{ __("string.Staticties") }}
    </x-widgets.sidebar-link>

   

    <x-widgets.sidebar-link href="{{Route('admin.backups')}}">
        {{ __("string.Backups") }}
    </x-widgets.sidebar-link>

</ul>
