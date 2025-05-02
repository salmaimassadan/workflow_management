@extends('layout')

@section('content')
@section('title', 'Edit User')
@section('breadcrumb', 'Edit User')
<head>
    <title>Edit User</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container">
        <div class="row" style="margin-top: 20px;">
            <div class="col-md-8 offset-md-2">
                <div class="card">
                    <div class="card-header">
                        <h3>Edit User</h3>
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
                        <form action="{{ route('employees.update', $employee->id) }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')
                            <div class="form-group">
                                <label for="name">Name</label>
                                <input type="text" name="name" class="form-control" id="name" value="{{ old('name', $employee->name) }}">
                            </div>
                            <div class="form-group">
                                <label for="firstname">Firstname</label>
                                <input type="text" name="firstname" class="form-control" id="firstname" value="{{ old('firstname', $employee->firstname) }}">
                            </div>
                            <div class="form-group">
                                <label for="email">Email</label>
                                <input type="email" name="email" class="form-control" id="email" value="{{ old('email', $employee->email) }}">
                            </div>
                            <div class="form-group">
                                <label for="phone">Phone</label>
                                <input type="text" name="phone" class="form-control" id="phone" value="{{ old('phone', $employee->phone) }}">
                            </div>
                            <div class="form-group">
                                <label for="role">Role</label>
                                <select name="role" class="form-control">
                                <option value="secrétaire" {{ $employee->role == 'secrétaire' ? 'selected' : '' }}>Secretary</option>
                                <option value="opérateur" {{ $employee->role == 'opérateur' ? 'selected' : '' }}>Operator</option>
                                <option value="indexeur" {{ $employee->role == 'indexeur' ? 'selected' : '' }}>Indexorr</option>
                                <option value="responsable" {{ $employee->role == 'responsable' ? 'selected' : '' }}>Responsable</option>
                                <option value="utilisateur" {{ $employee->role == 'utilisateur' ? 'selected' : '' }}>Utilisateur</option>

                            </select>
                            </div>

                            <div class="form-group">
                                <label for="image">Image</label>
                                <input type="file" name="image" class="form-control" id="image">
                            </div>
                            @if($employee->image)
                                <div class="form-group">
                                    <img src="{{ asset('storage/' . $employee->image) }}" alt="Image" width="100">
                                </div>
                            @endif
                            <div class="form-group">
                                <label for="service">Service</label>
                                <select name="service_id" class="form-control" id="service">
                                    @foreach($services as $service)
                                        <option value="{{ $service->id }}" {{ $employee->service_id == $service->id ? 'selected' : '' }}>{{ $service->name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="form-group">
                                <label for="password">Password (leave blank to keep current password)</label>
                                <input type="password" name="password" class="form-control" id="password">
                            </div>
                            <button type="submit" class="btn btn-outline-primary">Update User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
