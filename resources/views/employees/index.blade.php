@extends('layout')

@section('title', 'Users')
@section('breadcrumb', 'All Users')

@section('content')
<head>
    <title>Users CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css">
    <style>
        .form-input {
            display: flex;
            align-items: center;
            height: 36px;
            flex-grow: 1;
            padding: 0 16px;
            border: none;
            background: #f1f1f1;
            border-radius: 36px 0 0 36px;
            outline: none;
            width: 100%;
            color: #333;
        }

        .form-input input[type="search"] {
            flex-grow: 1;
            border: none;
            outline: none;
            background: transparent;
            color: #333;
            font-size: 18px;
        }

        .search-btn {
            display: flex;
            justify-content: center;
            align-items: center;
            width: 36px;
            height: 100%;
            border-radius: 0 36px 36px 0;
            background: #007bff;
            color: #fff;
            border: none;
            outline: none;
            cursor: pointer;
        }

        .btn-download {
            display: inline-flex;
            align-items: center;
            background-color: #007bff;
            color: white;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 16px;
        }

        .btn-download:hover {
            background-color: #333;
        }

        .btn-download i {
            margin-right: 8px;
        }
    </style>
</head>
<div class="container">
    <div class="row" style="margin:20px;">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h2>ALL USERS</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <a href="{{ route('employees.create') }}" class="btn btn-outline-dark btn-sm me-2" title="Add New User">
                        <i class="bi bi-file-earmark-plus"></i> Add New User
                        </a>
                        <form id="searchForm" action="{{ route('employees.index') }}" method="GET" class="flex-grow-1">
                            <div class="form-input">
                                <input type="search" name="search" placeholder="Search..." value="{{ request()->get('search') }}" oninput="document.getElementById('searchForm').submit();">
                            </div>
                        </form>
                        <a href="{{ route('employees.pdf') }}" class="btn-outline-info" id="downloadPdfButton">
                            <i class='bx bxs-cloud-download'></i>
                            <span class="text">Download PDF</span>
                        </a>
                    </div>
                    <br/>
                    <div class="table-responsive">
                        <table class="table table-bordered mt-4">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Firstname</th>
                                    <th>Email</th>
                                    <th>Phone</th>
                                    <th>Service</th>
                                    <th>
                                        Role
                                    </th>
                                    <th>Image</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($employees as $employee)
                                    <tr>
                                        <td>{{ $employee->id }}</td>
                                        <td>{{ $employee->name }}</td>
                                        <td>{{ $employee->firstname }}</td>
                                        <td>{{ $employee->email }}</td>
                                        <td>{{ $employee->phone }}</td>
                                        <td>{{ $employee->service->name ?? 'N/A' }}</td>
                                        <td>{{ $employee->role }}</td>
                                        <td>
                                            @if($employee->image)
                                                <img src="{{ asset('storage/' . $employee->image) }}" alt="Image" width="50">
                                            @endif
                                        </td>
                                        <td>
                                            <a href="{{ route('employees.show', $employee->id) }}" class="btn btn-link"><i class="bi bi-eye-fill"></i>View</a>
                                            <a href="{{ route('employees.edit', $employee->id) }}" class="btn btn-outline-secondary"><i class="bi bi-pencil-square"></i>Edit</a>
                                            <form action="{{ route('employees.destroy', $employee->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger"><i class="bi bi-calendar2-x"></i>Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        {{ $employees->links() }} 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXlki7QaLQbi0WIe47Wl7FqK8UXjLkT4F44aNSPQHwpP15Ff9W9eEnuOrJ5a" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9Ah7X4+971Xz1bC4oM1w7gu5Q6zV5q4D5RNwoF8rG5p6yufTOB6FHyL" crossorigin="anonymous"></script>


@endsection
