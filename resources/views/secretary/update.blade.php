@extends('secretary.layout')

@section('content')
@section('title', 'Edit Courrier')
@section('breadcrumb', 'Edit Courrier')
<head>
    <title>Edit Courrier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3>Edit Courrier</h3>
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
                    <form action="{{ route('secretary.edit', $courrier->id) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        <div class="form-group mb-3">
                            <label for="type">Type</label>
                            <select id="type" name="type" class="form-control" required>
                                <option value="entrant" {{ old('type', $courrier->type) == 'entrant' ? 'selected' : '' }}>Entrant</option>
                                <option value="sortant" {{ old('type', $courrier->type) == 'sortant' ? 'selected' : '' }}>Sortant</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="subject">Subject</label>
                            <input type="text" name="subject" class="form-control" id="subject" value="{{ old('subject', $courrier->subject) }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="content">Content</label>
                            <textarea name="content" class="form-control" id="content" required>{{ old('content', $courrier->content) }}</textarea>
                        </div>
                        <div class="form-group mb-3">
                            <label for="status">Status</label>
                            <select id="status" name="status" class="form-control" required>
                                <option value="traité" {{ old('status', $courrier->status) == 'traité' ? 'selected' : '' }}>Completed</option>
                                <option value="non lu" {{ old('status', $courrier->status) == 'non lu' ? 'selected' : '' }}>New</option>
                                <option value="archivé" {{ old('status', $courrier->status) == 'archivé' ? 'selected' : '' }}>Archived</option>
                                <option value="lu" {{ old('status', $courrier->status) == 'lu' ? 'selected' : '' }}>Read</option>
                                <option value="urgent" {{ old('status', $courrier->status) == 'urgent' ? 'selected' : '' }}>Urgent</option>
                            </select>
                        </div>
                        <div class="form-group mb-3">
                            <label for="sender">Sender</label>
                            <input type="text" name="sender" class="form-control" id="sender" value="{{ old('sender', $courrier->sender) }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="recipient">Recipient</label>
                            <input type="text" name="recipient" class="form-control" id="recipient" value="{{ old('recipient', $courrier->recipient) }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="created_at">Created At</label>
                            <input type="date" name="created_at" class="form-control" id="created_at" value="{{ old('created_at', $courrier->created_at->format('Y-m-d')) }}" required>
                        </div>
                        <div class="form-group mb-3">
                            <label for="document">Document</label>
                            <input type="file" name="document" class="form-control" id="document">
                            @if($courrier->document)
                                <div class="mt-2">
                                    <a href="{{ asset('storage/' . $courrier->document) }}" target="_blank">View Document</a>
                                </div>
                            @endif
                        </div>
                        <button type="submit" class="btn btn-outline-primary">Update Courrier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
