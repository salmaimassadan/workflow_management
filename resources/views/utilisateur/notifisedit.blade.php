@extends('utilisateur.layout')

@section('content')
    <div class="container">
        <h1>Edit Notification</h1>

        <form action="{{ route('utilisateur.notifisupdate', $notification->id) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="form-group">
                <label for="commentaire">Commentaire</label>
                <input type="text" id="commentaire" name="commentaire" value="{{ old('commentaire', $notification->commentaire) }}" class="form-control">
            </div>

            <div class="form-group">
                <label for="read_status">Read Status</label>
                <select id="read_status" name="read_status" class="form-control">
                    <option value="1" {{ $notification->read_status == 'lu' ? 'selected' : '' }}>Read</option>
                    <option value="0" {{ $notification->read_status == 'non lu' ? 'selected' : '' }}>Unread</option>
                </select>
            </div>

            <div class="form-group">
                <label for="deadline">Deadline</label>
                <input type="date" id="deadline" name="deadline" value="{{ old('deadline', $notification->deadline) }}" class="form-control">
            </div>

            <button type="submit" class="btn btn-primary">Save Changes</button>
        </form>

        <a href="{{ route('utilisateur.notifisindex') }}">Back to All Notifications</a>
    </div>
@endsection
