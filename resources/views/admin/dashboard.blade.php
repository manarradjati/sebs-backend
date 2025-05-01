@extends('layouts.app')

@section('content')
    <h1>لوحة التحكم</h1>
    <p>مرحباً، {{ auth()->user()->name }}</p>

    <h3>جميع التظاهرات</h3>
    <ul>
        @foreach ($events as $event)
            <li>{{ $event->title }} - <a href="{{ route('events.show', $event->id) }}">عرض</a></li>
        @endforeach
    </ul>
@endsection
