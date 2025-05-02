@extends('layout')

@section('title', 'Dossiers')
@section('breadcrumb', 'All Dossiers')

@section('content')
<head>
    <title>Dossiers CRUD</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.7.2/font/bootstrap-icons.min.css">
    <style>
        .search-container {
            display: flex;
            align-items: center;
            height: 36px;
            border: 1px solid #ced4da;
            border-radius: 20px;
            overflow: hidden;
            background: #f1f1f1;
        }

        .search-input {
            flex-grow: 1;
            border: none;
            outline: none;
            padding: 0 16px;
            font-size: 16px;
            color: #333;
        }

        .search-btn {
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 100%;
            background: #007bff;
            color: #fff;
            border: none;
            cursor: pointer;
        }

        .search-btn i {
            font-size: 18px;
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
                    <h2>ALL DOSSIERS</h2>
                </div>
                <div class="card-body">
                    <div class="d-flex mb-3">
                        <a href="{{ route('dossiers.create') }}" class="btn btn-outline-dark btn-sm me-2" title="Add New Dossier">
                            <i class="bi bi-file-earmark-plus"></i> Add New Dossier
                        </a>
                        <form id="searchForm" action="{{ route('dossiers.index') }}" method="GET" class="flex-grow-1">
                            <div class="search-container">
                                <input type="search" name="search" id="searchInput" placeholder="Search..." value="{{ request()->get('search') }}" class="search-input">
                                <button type="submit" class="search-btn">
                                    <i class="bi bi-search"></i>
                                </button>
                            </div>
                        </form>
                        <a href="{{ route('dossiers.pdf') }}" class="btn-outline-info" id="downloadPdfButton">
                            <i class='bx bxs-cloud-download'></i>
                            <span class="text">Download PDF</span>
                        </a>
                    </div>
                    <br/>
                    <div class="table-responsive">
                        <table class="table table-bordered mt-4" id="dossiersTable">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Reference</th>
                                    <th>Title</th>
                                    <th>Description</th>
                                    <th>Courriers</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($dossiers as $dossier)
                                    <tr>
                                        <td>{{ $dossier->id }}</td>
                                        <td>{{ $dossier->reference }}</td>
                                        <td>{{ $dossier->title }}</td>
                                        <td>{{ $dossier->description }}</td>
                                        <td>
                                            <!-- Display references of associated courriers -->
                                            @foreach ($dossier->courriers as $courrier)
                                                <span>{{ $courrier->reference }}</span>@if (!$loop->last), @endif
                                            @endforeach
                                        </td>
                                        <td>
                                            <a href="{{ route('dossiers.show', $dossier->id) }}" class="btn btn-link"><i class="bi bi-eye-fill"></i> View</a>
                                            <a href="{{ route('dossiers.edit', $dossier->id) }}" class="btn btn-outline-secondary"><i class="bi bi-pencil-square"></i> Edit</a>
                                            <form action="{{ route('dossiers.destroy', $dossier->id) }}" method="POST" style="display:inline;">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="btn btn-outline-danger"><i class="bi bi-calendar2-x"></i> Delete</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                        <!-- Pagination links -->
                        {{ $dossiers->links() }} 
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.9.2/dist/umd/popper.min.js" integrity="sha384-IQsoLXlki7QaLQbi0WIe47Wl7FqK8UXjLkT4F44aNSPQHwpP15Ff9W9eEnuOrJ5a" crossorigin="anonymous"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9Ah7X4+971Xz1bC4oM1w7gu5Q6zV5q4D5RNwoF8rG5p6yufTOB6FHyL" crossorigin="anonymous"></script>
<script>
    document.getElementById('searchInput').addEventListener('input', function() {
        const query = this.value.toLowerCase();
        const rows = document.querySelectorAll('#dossiersTable tbody tr');

        rows.forEach(row => {
            const cells = row.querySelectorAll('td');
            const reference = cells[1].textContent.toLowerCase();
            const title = cells[2].textContent.toLowerCase();
            const description = cells[3].textContent.toLowerCase();

            if (reference.includes(query) || title.includes(query) || description.includes(query)) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
            }
        });
    });
</script>

@endsection
