@extends('layout')

@section('title', 'Service Details')
@section('breadcrumb', 'Service Details')

@section('content')
<head>
    <title>Service Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3>Service Details</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Name:</strong> {{ $service->name }}</p>
                        <p><strong>Description:</strong> {{ $service->description }}</p>
                        <a href="{{ route('services.edit', $service->id) }}" class="btn btn-outline-secondary">Edit</a>
                        <a href="{{ route('services.index') }}" class="btn btn-outline-primary">Back to List</a>
                        <a href="{{ route('pdf.download.view', ['id' => $service->id]) }}" class="btn-download btn btn-link">
                            <i class='bx bxs-cloud-download'></i>
                            <span class="text">Download PDF</span>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
@endsection
