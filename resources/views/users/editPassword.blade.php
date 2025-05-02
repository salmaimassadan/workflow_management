@extends('layout')

@section('content')
@section('title', 'Update Password')
@section('breadcrumb', 'Update Password')

<head>
    <title>Update Password</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<body>
    <div class="container mt-5">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card">
                <div class="card-header bg-primary text-white">
                        <h3 class="mb-0">Edit Admin's Password</h3>
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
                        <form action="{{ route('users.update-password', $user->id) }}" method="POST">
    @csrf
    @method('PUT')

    <div class="form-group">
        <label for="old_password">Old Password</label>
        <input type="password" name="old_password" id="old_password" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="new_password">New Password</label>
        <input type="password" name="new_password" id="new_password" class="form-control" required>
    </div>

    <div class="form-group">
        <label for="new_password_confirmation">Confirm New Password</label>
        <input type="password" name="new_password_confirmation" id="new_password_confirmation" class="form-control" required>
    </div>

    <button type="submit" class="btn btn-primary">Update Password</button>
</form>

                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection
