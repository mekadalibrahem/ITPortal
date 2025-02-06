<ul class="flex flex-col space-y-1">
    <x-widgets.sidebar-link href="{{Route('dashboard.index')}}">
        <x-svg.home />
        {{__("string.Dashboard")}}
    </x-widgets.sidebar-link>

    {{-- <x-widgets.sidebar-link href="{{ Route('employee.requests') }}" >
        {{ __("string.Employee Requests")}}
    </x-widgets.sidebar-link> --}}
</ul>
