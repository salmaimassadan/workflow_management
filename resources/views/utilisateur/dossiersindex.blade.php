@extends('utilisateur.layout')

@section('title', 'Directories')
@section('breadcrumb', 'My Directories')

@section('content')
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="_token" content="{{ csrf_token() }}" />
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
            background-color: #0056b3;
        }

        .btn-download i {
            margin-right: 8px;
        }

        .btn-count {
            display: flex;
            align-items: center;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 50px;
            padding: 10px 20px;
            margin: 5px;
            font-size: 16px;
            text-decoration: none;
            transition: background-color 0.3s, transform 0.3s;
        }

        .btn-count i {
            margin-right: 8px;
        }

        .btn-count:hover {
            background-color: #0056b3;
            transform: scale(1.05);
        }

        .btn-count.read {
            background-color: #28a745;
        }

        .btn-count.read:hover {
            background-color: #218838;
        }

        .btn-count.unread {
            background-color: #ffc107;
        }

        .btn-count.unread:hover {
            background-color: #e0a800;
        }

        .btn-count.urgent {
            background-color: #dc3545;
        }

        .btn-count.urgent:hover {
            background-color: #c82333;
        }

        .btn-count.archived {
            background-color: #6c757d;
        }

        .btn-count.archived:hover {
            background-color: #5a6268;
        }

        .btn-count.completed {
            background-color: #17a2b8;
        }

        .btn-count.completed:hover {
            background-color: #117a8b;
        }
    </style>
</head>

<div class="container mt-5">
    <h1 class="text-center mb-4">Directories Management</h1>

    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <form action="{{ route('utilisateur.dossiersindex') }}" method="GET" class="d-flex w-50">
                <input type="text" name="search" class="form-control me-2 form-input" placeholder="Rechercher..." value="{{ request('search') }}">
                <button type="submit" class="btn btn-outline-secondary search-btn">
                    <i class="bi bi-search"></i>
                </button>
            </form>

            <a href="{{ route('utilisateur.dossierscreate') }}" class="btn btn-success">
                <i class="bi bi-plus-circle"></i> Créer un Nouveau Dossier
            </a>
        </div>

        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped">
                    <thead>
                        <tr>
                            <th scope="col">Titre</th>
                            <th scope="col">Description</th>
                            <th scope="col">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse ($dossiers as $dossier)
                            <tr>
                                <td>{{ $dossier->title }}</td>
                                <td>{{ Str::limit($dossier->description, 50) }}</td>
                                <td class="d-flex gap-2">
                                    <a href="{{ route('utilisateur.dossiersshow', $dossier) }}" class="btn btn-outline-primary">
                                        <i class="bi bi-eye-fill"></i> View
                                    </a>
                                    <a href="{{ route('utilisateur.dossiersedit', $dossier) }}" class="btn btn-outline-warning">
                                        <i class="bi bi-pencil"></i> Edit
                                    </a>
                                    <form action="{{ route('utilisateur.dossiersdestroy', $dossier) }}" method="POST" class="d-inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-outline-danger">
                                            <i class="bi bi-trash"></i> Delete
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="3" class="text-center">Aucun dossier trouvé.</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>
        </div>

        <div class="card-footer">
            {{ $dossiers->links() }}
        </div>
    </div>
</div>
@endsection
