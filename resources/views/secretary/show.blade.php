@extends('secretary.layout')

@section('title', 'View Courrier')
@section('breadcrumb', 'View Courrier')

@section('content')
<head>
    <title>Show Courrier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3>Show Courrier</h3>
                    </div>
                    <div class="card-body">
                    <div class="mb-3">
                        <strong class="form-label">Reference</strong>
                        <p class="text-muted">{{ $courrier->reference }}</p>
                    </div>
                    <div class="mb-3">
                        <strong class="form-label">Type</strong>
                        <p class="text-muted">{{ $courrier->type }}</p>
                    </div>
                    <div class="mb-3">
                        <strong class="form-label">Subject</strong>
                        <p class="text-muted">{{ $courrier->subject }}</p>
                    </div>
                    <div class="mb-3">
                        <strong class="form-label">Content</strong>
                        <p class="text-muted">{{ $courrier->content }}</p>
                    </div>
                    <div class="mb-3">
                        <strong class="form-label">Status</strong>
                        <p class="text-muted">{{ $courrier->status }}</p>
                    </div>
                    <div class="mb-3">
                        <strong class="form-label">Sender</strong>
                        <p class="text-muted">{{ $courrier->sender }}</p>
                    </div>
                    <div class="mb-3">
                        <strong class="form-label">Recipient</strong>
                        <p class="text-muted">{{ $courrier->recipient }}</p>
                    </div>
                    <div class="mb-3">
                        <strong class="form-label">Created At</strong>
                        <p class="text-muted">{{ $courrier->created_at->format('Y-m-d') }}</p>
                    </div>
                    <div class="mb-3">
                        <strong class="form-label">Document</strong>
                        @if($courrier->document)
                            <a href="{{ asset('storage/' . $courrier->document) }}" class="btn btn-outline-info" target="_blank">View Document</a>
                        @else
                            <p class="text-muted">No document available.</p>
                        @endif
                    </div>
                    <div class="d-flex justify-content-between mt-4">
                        <a href="{{ route('secretary.index') }}" class="btn btn-outline-primary">Back to List</a>
                        <a href="{{ route('secretary.edit', $courrier->id) }}" class="btn btn-outline-secondary">Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
