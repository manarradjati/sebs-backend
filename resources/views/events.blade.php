<!DOCTYPE html>
<html>
<head>
    <title>قائمة الأحداث</title>
</head>
<body>
    <h1>قائمة الأحداث</h1>

    @foreach ($events as $event)
        <div style="border: 1px solid #ccc; padding: 15px; margin-bottom: 20px;">
            <h2>{{ $event->title }}</h2>
            <p><strong>التصنيف:</strong> {{ $event->category->name ?? 'غير محدد' }}</p>
            <p><strong>المنظم:</strong> {{ $event->organizer->name ?? 'غير محدد' }}</p>
            <p><strong>السعر:</strong> {{ $event->price }} د.ت</p>
            <p><strong>من:</strong> {{ $event->start_date }} إلى {{ $event->end_date }}</p>
            <a href="{{ route('event.detail', $event->id) }}">تفاصيل</a>
        </div>
    @endforeach

</body>
</html>
