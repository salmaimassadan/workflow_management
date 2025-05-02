@extends('layout')

@section('content')
@section('title', 'View Courrier')
@section('breadcrumb', 'View Courrier')

<head>
    <title>View Courrier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3>View Courrier</h3>
                    </div>
                    <div class="card-body">
                        <div class="form-group">
                            <label for="reference">Reference</label>
                            <p>{{ $courrier->reference }}</p>
                        </div>
                        <div class="form-group">
                            <label for="type">Type</label>
                            <p>{{ $courrier->type }}</p>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <p>{{ $courrier->subject }}</p>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <p>{{ $courrier->content }}</p>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <p>{{ $courrier->status }}</p>
                        </div>
                        <div class="form-group">
                            <label for="sender">Sender</label>
                            <p>{{ $courrier->sender }}</p>
                        </div>
                        <div class="form-group">
                            <label for="recipient">Recipient</label>
                            <p>{{ $courrier->recipient }}</p>
                        </div>
                        <div class="form-group">
                            <label for="created_at">Created At</label>
                            <p>{{ $courrier->created_at->format('Y-m-d') }}</p>
                        </div>
                        <div class="form-group">
                            <label for="document">Document</label>
                            @if($courrier->document)
                                <div class="form-group">
                                    <a href="{{ asset('storage/' . $courrier->document) }}" target="_blank">View Document</a>
                                </div>
                            @else
                                <p>No document available.</p>
                            @endif
                        </div>
                        <a href="{{ route('courriers.index') }}" class="btn btn-outline-primary">Back to List</a>
                        <a href="{{ route('courriers.edit', $courrier->id) }}" class="btn btn-outline-secondary">Edit</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
