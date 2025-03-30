<ul class="flex flex-col space-y-1">
    <x-widgets.sidebar-link href="{{Route('admin.staticties')}}">
        <x-svg.dashboard-matric />
        {{ __("string.Staticties") }}
    </x-widgets.sidebar-link>
    <x-widgets.accordion-item title='{{__("string.Authorization")}}'>
        <x-slot name="icon">
            <x-svg.user-manager class="w-4 h-4" />
        </x-slot>
        <x-widgets.accordion-child-link href="{{Route('admin.auth.permission.index')}}">
            {{__("string.Permissions")}}
        </x-widgets.accordion-child-link>
        <x-widgets.accordion-child-link href="{{Route('admin.auth.role.index')}}">
            {{__("string.Roles")}}
        </x-widgets.accordion-child-link>
        <x-widgets.accordion-child-link href="{{Route('admin.auth.user.index')}}">
            {{__("string.Users")}}
        </x-widgets.accordion-child-link>

    </x-widgets.accordion-item>

  <!--  request section link -->
  <x-widgets.accordion-item title='{{__("string.Manage requests")}}'>
    <x-slot name="icon">
        <x-svg.orders class="w-4 h-4" />
    </x-slot>
    <x-widgets.accordion-child-link href="{{Route('admin.requests.type.index')}}">
        {{ __("string.Request type") }}
    </x-widgets.accordion-child-link>
    <x-widgets.accordion-child-link href="{{Route('admin.requests.request.index')}}">
        {{ __("string.Requests") }}
    </x-widgets.accordion-child-link>


</x-widgets.accordion-item>

 <!-- employee section  link -->
 <x-widgets.accordion-item title='{{__("string.Manage employees")}}'>
    <x-slot name="icon">
        <x-svg.team class="w-4 h-4" />
    </x-slot>
    <x-widgets.accordion-child-link href="{{Route('admin.department.index')}}">
        {{ __("string.Departments") }}
    </x-widgets.accordion-child-link>
    <x-widgets.accordion-child-link href="{{Route('admin.employee.index')}}">
        {{ __("string.Employees") }}
    </x-widgets.accordion-child-link>


</x-widgets.accordion-item>


    <x-widgets.sidebar-link href="{{Route('admin.collage.index')}}">
        <x-svg.collage />
        {{ __("string.Collage informations") }}
    </x-widgets.sidebar-link>
    <x-widgets.sidebar-link href="{{Route('admin.backups')}}">
        <x-svg.backup />
        {{ __("string.Backups") }}
    </x-widgets.sidebar-link>

</ul>
