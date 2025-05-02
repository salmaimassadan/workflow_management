@extends('layout')

@section('title', 'Upload Document')
@section('breadcrumb', 'Upload Document')

@section('content')
<head>
    <title>Upload Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="container mt-4">
    <div class="row" style="margin-top: 20px;">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>Upload Document</h3>
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
                    <form action="{{ route('upload.process') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="document">Choose Document (Image or PDF):</label>
                            <input type="file" name="document" class="form-control" id="document" required>
                        </div>
                        
                        <button type="submit" class="btn btn-primary mt-2">Upload and Process</button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    @isset($extractedData)
    <div class="row mt-4">
        <div class="col-md-6 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>Extracted Data</h3>
                </div>
                <div class="card-body">
                    <pre style="font-size: 1.25em; white-space: pre-wrap;">{{ $extractedData }}</pre>
                </div>
            </div>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>Save Courrier Details</h3>
                </div>
                <div class="card-body">
                    <form action="{{ route('courriers.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="type">Type</label>
                            <select id="type" name="type" class="form-control" required>
                                <option value="entrant">Entrant</option>
                                <option value="sortant">Sortant</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="subject">Subject</label>
                            <input type="text" name="subject" class="form-control" id="subject" value="{{ old('subject') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="content">Content</label>
                            <textarea name="content" class="form-control" id="content" required>{{ $extractedData }}</textarea>
                        </div>
                        <div class="form-group">
                            <label for="status">Status</label>
                            <select id="status" name="status" class="form-control" required>
                                <option value="traité">Completed</option>
                                <option value="non lu">New</option>
                                <option value="archivé">Archived</option>
                                <option value="lu">In progress</option>
                                <option value="urgent">Urgent</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="sender">Sender</label>
                            <input type="text" name="sender" class="form-control" id="sender" value="{{ old('sender') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="recipient">Recipient</label>
                            <input type="text" name="recipient" class="form-control" id="recipient" value="{{ old('recipient') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="created_at">Added at</label>
                            <input type="date" name="created_at" class="form-control" id="created_at" value="{{ old('created_at') }}" required>
                        </div>
                        <div class="form-group">
                            <label for="document">Upload Document</label>
                            <input type="file" name="document" class="form-control" id="document" required>
                        </div>
                        <button type="submit" class="btn btn-outline-primary mt-2">Save Courrier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @endisset
</div>
@endsection
