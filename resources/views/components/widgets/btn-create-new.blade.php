@props(['href' , "text" => "New"])

<x-button status="primary" >
    <a href="{{$href}}">
        {{$text}}
    </a>
</x-button>
