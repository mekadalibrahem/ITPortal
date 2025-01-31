@props(['href' , "text" => "New"])
<a href="{{$href}}">
    <x-button status="primary" type="button">
        {{$text}}
    </x-button>
</a>
