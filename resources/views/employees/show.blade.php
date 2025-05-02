@extends('layout')

@section('title', 'User Details')
@section('breadcrumb', 'User Details')

@section('content')
<head>
    <title>User Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3>User Details</h3>
                    </div>
                    <div class="card-body">
                        <p><strong>Firstname:</strong> {{ $employee->firstname }}</p>
                        <p><strong>Name:</strong> {{ $employee->name }}</p>
                        <p><strong>Email:</strong> {{ $employee->email }}</p>
                        <p><strong>Phone:</strong> {{ $employee->phone }}</p>
                        <p><strong>Service name:</strong> {{ $employee->phone }}</p>
                        <p><strong>Phone:</strong> {{ $employee->name }}</p>
                        <p><strong>Password:</strong> {{ $employee->password }}</p>
                        <p><strong>Image:</strong></p>
                        @if($employee->image)
                            <img src="{{ asset('storage/' . $employee->image) }}" alt="Employee Image" width="100">
                        @else
                            <p>No image available</p>
                        @endif
                        <br>
                        <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-outline-secondary">Edit</a>
                        <a href="{{ route('employees.index') }}" class="btn btn-outline-primary">Back to List</a>
                        <a href="{{ route('pdf.employee.details', ['id' => $employee->id]) }}" class="btn btn-outline-info">
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
