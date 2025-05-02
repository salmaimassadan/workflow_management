@extends('layout')

@section('title', 'View Response')
@section('breadcrumb', 'Response Details')

@section('content')
<head>
    <title>View Response</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <div class="row">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3>Response Details</h3>
                    </div>
                    <div class="card-body">
                    <div class="card-body">
                    <div class="mb-4">
                        <h6 class="text-muted">Courrier Reference:</h6>
                        <p class="fs-5">{{ $answer->courrier->reference }}</p>
                    </div>
                    <div class="mb-4">
                        <h6 class="text-muted">Created By:</h6>
                        <p class="fs-5">{{ $answer->creator->name }}</p>
                    </div>
                    <div class="mb-4">
                        <h6 class="text-muted">Content:</h6>
                        <p class="fs-5">{{ $answer->content }}</p>
                    </div>
                    <div class="mb-4">
                        <h6 class="text-muted">Created At:</h6>
                        <p class="fs-5">{{ $answer->created_at->format('d-m-Y H:i') }}</p>
                    </div>
                </div>
                    <div class="card-footer text-right">
                        <a href="{{ route('answers.index') }}" class="btn btn-secondary">Back to List</a>
                        <form action="{{ route('answers.destroy', $answer->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger" onclick="return confirm('Are you sure you want to delete this response?')">Delete Response</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
