@extends('layout')

@section('content')
@section('title', 'DISTRIBUTIONS')
@section('breadcrumb', 'All Distributions')

<head>
    <title>Edit Distribution</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3>Edit Distribution</h3>
                    </div>
                    <div class="card-body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        <form action="{{ route('distributions.update', $distribution->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            
                            <div class="mb-3">
                                <label for="sent_to" class="form-label">Sent To</label>
                                <input type="text" name="user_id" class="form-control" id="sent_to" value="{{ old('user_id', $distribution->employee->name) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="commentaire" class="form-label">Commentaire</label>
                                <input type="text" name="commentaire" class="form-control" id="commentaire" value="{{ old('commentaire', $distribution->commentaire) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="read_status" class="form-label">Read Status</label>
                                <select name="read_status" class="form-control" id="read_status" required>
                                    <option value="1" {{ old('read_status', $distribution->read_status) == 1 ? 'selected' : '' }}>Read</option>
                                    <option value="0" {{ old('read_status', $distribution->read_status) == 0 ? 'selected' : '' }}>Unread</option>
                                </select>
                            </div>
                            <div class="mb-3">
                                <label for="deadline" class="form-label">Deadline</label>
                                <input type="date" name="deadline" class="form-control" id="deadline" value="{{ old('deadline', $distribution->deadline) }}" required>
                            </div>
                            
                            <button type="submit" class="btn btn-primary">Update Distribution</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
