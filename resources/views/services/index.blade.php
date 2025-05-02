@extends('layout')

@section('title', 'Services')
@section('breadcrumb', 'All Services')

@section('content')
<head>
    <title>Services CRUD</title>
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
                    <h2>ALL SERVICES</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <a href="{{ route('services.create') }}" class="btn btn-outline-dark btn-sm me-2" title="Add New Service">
                            <i class="bi bi-file-earmark-plus"></i> Add New Service
                        </a>
                        <form id="searchForm" action="{{ route('services.index') }}" method="GET" class="flex-grow-1">
                            <div class="form-input">
                                <input type="search" name="search" placeholder="Search..." value="{{ request()->get('search') }}" oninput="document.getElementById('searchForm').submit();">
                            </div>
                        </form>
                        <a href="{{ route('pdf.download') }}" class="btn btn-outline-info" id="downloadPdfButton">
                        <i class='bx bxs-cloud-download'></i>
                        <span class="text">Download PDF</span>
                        </a>

                    </div>
                    <br/>
                    <div class="table-responsive">
                        <table class="table">
                            <thead>
                                <tr>
                                    <th>#</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                            @foreach($services as $service)
                                <tr>
                                    <td>{{ $service->id }}</td>
                                    <td>{{ $service->name }}</td>
                                    <td>{{ $service->description }}</td>
                                    <td>
                                        <a href="{{ route('services.show', $service->id) }}" title="View Service"><button class="btn btn-link btn-sm"><i class="bi bi-eye-fill"></i> View</button></a>
                                        <a href="{{ route('services.edit', $service->id) }}" title="Edit Service"><button class="btn btn-outline-secondary btn-sm"><i class="bi bi-pencil-square"></i> Edit</button></a>
                                        <form method="POST" action="{{ route('services.destroy', $service->id) }}" accept-charset="UTF-8" style="display:inline">
                                            {{ method_field('DELETE') }}
                                            {{ csrf_field() }}
                                            <button type="submit" class="btn btn-outline-danger btn-sm" title="Delete Service" onclick="return confirm(&quot;Confirm delete?&quot;)"><i class="bi bi-calendar2-x"></i> Delete</button>
                                        </form>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                        {{ $services->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXlki7QaLQbi0WIe47Wl7FqK8UXjLkT4F44aNSPQHwpP15Ff9W9eEnuOrJ5a" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9Ah7X4+971Xz1bC4oM1w7gu5Q6zV5q4D5RNwoF8rG5p6yufTOB6FHyL" crossorigin="anonymous"></script>
<script>
    document.getElementById('downloadPdfButton').addEventListener('click', function(event) {
        event.preventDefault();

        var a = document.createElement('a');
        a.href = this.href;
        a.download = 'document.pdf';

        document.body.appendChild(a);
        a.click();

        document.body.removeChild(a);
    });
</script>

@endsection
