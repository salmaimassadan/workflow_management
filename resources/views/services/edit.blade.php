@extends('layout')

@section('content')
@section('title', 'SERVICES')
@section('breadcrumb', 'All Services')
<head>
    <title>Edit Service</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3>Edit Service</h3>
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
                        <form action="{{ route('services.update', $service->id) }}" method="POST">
                            @csrf
                            @method('PUT')
                            <div class="mb-3">
                                <label for="name" class="form-label">Name</label>
                                <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $service->name) }}" required>
                            </div>
                            <div class="mb-3">
                                <label for="description" class="form-label">Description</label>
                                <input type="text" name="description" class="form-control" id="description" value="{{ old('description', $service->description) }}" required>
                            </div>
                            
                            <button type="submit" class="btn btn-outline-primary">Update</button>
                            <a href="{{ route('services.show', $service->id) }}" class="btn btn-outline-secondary">Cancel</a>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
