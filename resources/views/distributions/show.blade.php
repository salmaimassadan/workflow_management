@extends('layout')

@section('title', 'View Distribution')
@section('breadcrumb', 'Distribution Details')

@section('content')
<head>
    <title>View Distribution</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3>Distribution Details</h3>
                    </div>
                    <div class="card-body">
                        <div class="mb-3">
                            <label class="form-label">Courrier Reference:</label>
                            <p>{{ $distribution->courrier->reference }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Sent To:</label>
                            <p>{{ $distribution->employee ? $distribution->employee->name : 'N/A' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Service:</label>
                            <p>{{ $distribution->service ? $distribution->service->name : 'N/A' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Commentaire:</label>
                            <p>{{ $distribution->commentaire }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Read Status:</label>
                            <p>{{ $distribution->read_status ? 'Read' : 'Unread' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Deadline:</label>
                            <p>{{ $distribution->deadline ? $distribution->deadline->format('Y-m-d') : 'No Deadline' }}</p>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Created By:</label>
                            <p>{{ $distribution->creator ? $distribution->creator->name : 'Unknown' }}</p>
                        </div>
                    </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('distributions.index') }}" class="btn btn-secondary">Back to List</a>
                        <form action="{{ route('distributions.destroy', $distribution->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this distribution?')">Delete Distribution</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
