@extends('layout')

@section('content')
@section('title', 'Create User')
@section('breadcrumb', 'Create User')
<head>
    <title>Create user</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="container">
    <div class="row" style="margin-top: 20px;">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>Create user</h3>
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
                    <form action="{{ route('employees.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <div class="form-group">
                            <label for="name">Name</label>
                            <input type="text" name="name" class="form-control" id="name" value="{{ old('name') }}">
                        </div>
                        <div class="form-group">
                            <label for="firstname">Firstname</label>
                            <input type="text" name="firstname" class="form-control" id="firstname" value="{{ old('firstname') }}">
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="email" name="email" class="form-control" id="email" value="{{ old('email') }}">
                        </div>
                        <div class="form-group">
                            <label for="phone">Phone</label>
                            <input type="text" name="phone" class="form-control" id="phone" value="{{ old('phone') }}">
                        </div>
                        <div class="form-group">
                            <label for="image">Image</label>
                            <input type="file" name="image" class="form-control" id="image">
                        </div>
                        <div class="form-group">
                            <label for="role">Role</label>
                            <select name="role" class="form-control">
                            <option value="utilisateur">Utilisateur</option>
                            </select>
                            </div>
                        <div class="form-group">
                            <label for="service">Service</label>
                            <select name="service_id" class="form-control" id="service">
                                @foreach($services as $service)
                                    <option value="{{ $service->id }}">{{ $service->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div class="form-group">
                            <label for="password">Password</label>
                            <input type="password" name="password" class="form-control" id="password">
                        </div>
                        <button type="submit" class="btn btn-outline-primary">Add User</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
