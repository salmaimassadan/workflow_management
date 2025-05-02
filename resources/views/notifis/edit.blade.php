@extends('secretary.layout')

@section('content')
    <h1>Éditer la Notification</h1>

    <form action="{{ route('notifis.update', $notification->id) }}" method="POST">
        @csrf
        @method('PUT')

        <label for="commentaire">Commentaire:</label>
        <input type="text" name="commentaire" value="{{ $notification->commentaire }}" required>

        <label for="read_status">Statut de lecture:</label>
        <select name="read_status" required>
            <option value="1" {{ $notification->read_status ? 'selected' : '' }}>Lue</option>
            <option value="0" {{ !$notification->read_status ? 'selected' : '' }}>Non lue</option>
        </select>

        <label for="deadline">Deadline:</label>
        <input type="date" name="deadline" value="{{ $notification->deadline }}">

        <button type="submit">Mettre à jour</button>
    </form>
@endsection
