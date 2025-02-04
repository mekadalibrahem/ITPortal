@props(['href' , "text" => "New"])
<a href="{{$href}}">
    <x-button status="primary" type="button" size="sm" class="font-smal">
       <x-svg.plus />
    </x-button>
</a>
