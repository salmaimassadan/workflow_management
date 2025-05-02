@extends('secretary.layout')

@section('content')
    <h1>Liste des Notifications</h1>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Commentaire</th>
                <th>Statut de lecture</th>
                <th>Deadline</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notifications as $notification)
                <tr>
                    <td>{{ $notification->id }}</td>
                    <td>{{ $notification->commentaire }}</td>
                    <td>{{ $notification->read_status ? 'Lue' : 'Non lue' }}</td>
                    <td>{{ $notification->deadline }}</td>
                    <td>
                        <a href="{{ route('notifis.show', $notification->id) }}">Afficher</a>
                        <a href="{{ route('notifis.edit', $notification->id) }}">Éditer</a>
                        <form action="{{ route('notifis.destroy', $notification->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
