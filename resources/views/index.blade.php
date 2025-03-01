@extends('layouts.app')


@section('title','The List of Tasks!')
@section('content')
<nav class="mb-4">
    <a href="{{route('tasks.create')}}"
    class="font-medium text-gray-700 underline decoration-pink-500">
        Create a new task
    </a>
</nav>
@forelse($tasks as $task)
<div>
{{-- <a href="{{route('tasks.show',['id' => $task ->id])}}">{{$task -> title}}</a> --}}
<a href="{{route('tasks.show',['task' => $task ->id])}}"
    @class(['line-through' => $task->completed])>
    {{$task -> title}}</a>

</div>
@empty
<div>No tasks found.</div>

@endforelse

@if($tasks->count())

<nav class="mt-4">
    {{ $tasks->links()}}
</nav>

@endif
@endsection



{{-- <div> --}}
{{-- @if(count($tasks))
    @foreach($tasks as $task)
        <div>{{$task -> title}}</div>
    @endforeach
@else
    <div>No tasks found.</div>
@endif --}}


{{-- @forelse($tasks as $task)
<div>{{$task -> title}}</div>

@empty
<div>No tasks found.</div>

@endforelse --}}


{{-- @forelse($tasks as $task)
<div>
<a href="{{route('tasks.show',['id' => $task ->id])}}">{{$task -> title}}</a>
</div>
@empty
<div>No tasks found.</div>

@endforelse


</div> --}}