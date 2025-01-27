{{-- @if($errors->get('email') !== '') --}}
@props(['message' => [] ])

@if($message !== [])
<div class="p-1 text-sm text-red-800 rounded-lg bg-red-50 dark:bg-gray-800 dark:text-red-400" role="alert">
    @foreach ( $message as $error )
    {{$error }}
    @endforeach
</div>

@endif




