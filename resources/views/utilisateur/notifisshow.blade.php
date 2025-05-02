@extends('utilisateur.layout')

@section('content')
    <div class="container">
        <h1>{{ $notification->title }}</h1>
        <p>{{ $notification->body }}</p>
        <p>Status: {{ $notification->read_status == 'lu' ? 'Read' : 'Unread' }}</p>

        <form action="{{ route('utilisateur.markAsRead', $notification->id) }}" method="GET">
            <button type="submit">Mark as Read</button>
        </form>

        <a href="{{ route('utilisateur.notifisedit', $notification->id) }}">Edit</a>

        <form action="{{ route('utilisateur.notifisdestroy', $notification->id) }}" method="POST" onsubmit="return confirm('Are you sure?');">
            @csrf
            @method('DELETE')
            <button type="submit">Delete</button>
        </form>

        <a href="{{ route('utilisateur.notifisindex') }}">Back to All Notifications</a>
    </div>
@endsection
