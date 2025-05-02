@extends('secretary.layout')

@section('content')
    <h1>Détails de la Notification</h1>

    <p>ID: {{ $notification->id }}</p>
    <p>Commentaire: {{ $notification->commentaire }}</p>
    <p>Statut de lecture: {{ $notification->read_status ? 'Lue' : 'Non lue' }}</p>
    <p>Deadline: {{ $notification->deadline }}</p>

    <a href="{{ route('notifis.edit', $notification->id) }}">Éditer</a>
    <form action="{{ route('notifis.destroy', $notification->id) }}" method="POST">
        @csrf
        @method('DELETE')
        <button type="submit">Supprimer</button>
    </form>
@endsection
