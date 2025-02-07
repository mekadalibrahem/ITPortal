<ul class="flex flex-col space-y-1">
    <x-widgets.sidebar-link href="{{Route('admin.staticties')}}">
        {{ __("string.Staticties") }}
    </x-widgets.sidebar-link>
    <x-widgets.accordion-item title='{{__("string.Authorization")}}'>
        <x-slot name="icon">
            <x-svg.account class="w-4 h-4" />
        </x-slot>
        <x-widgets.accordion-child-link href="{{Route('admin.auth.permission')}}">
            {{__("string.Permissions")}}
        </x-widgets.accordion-child-link>
        <x-widgets.accordion-child-link href="{{Route('admin.auth.role')}}">
            {{__("string.Roles")}}
        </x-widgets.accordion-child-link>
        <x-widgets.accordion-child-link href="{{Route('admin.auth.user')}}">
            {{__("string.Users")}}
        </x-widgets.accordion-child-link>

    </x-widgets.accordion-item>



    <x-widgets.sidebar-link href="{{Route('admin.backups')}}">
        {{ __("string.Backups") }}
    </x-widgets.sidebar-link>

</ul>
