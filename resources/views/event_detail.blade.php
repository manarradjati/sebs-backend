<!DOCTYPE html>
<html>
<head>
    <title>{{ $event->title }}</title>
</head>
<body>
    <h1>{{ $event->title }}</h1>
    <p><strong>Organized by:</strong> {{ $event->organizer->name ?? 'N/A' }}</p>
    <p><strong>Category:</strong> {{ $event->category->name ?? 'N/A' }}</p>
    <p><strong>Description:</strong> {{ $event->description }}</p>
    <p><strong>Start:</strong> {{ $event->start_date }}</p>
    <p><strong>End:</strong> {{ $event->end_date }}</p>
    <p><strong>Price:</strong> {{ $event->price }} TND</p>
    <p><strong>Status:</strong> {{ $event->status }}</p>
    <p><strong>Tags:</strong> {{ implode(', ', $event->tags ?? []) }}</p>
</body>
</html>
