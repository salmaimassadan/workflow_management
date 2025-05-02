@extends('utilisateur.layout')

@section('title', 'Distributions')
@section('breadcrumb', 'All Distributions')

@section('content')
<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .table th, .table td {
            text-align: center;
        }

        .table thead th {
            background-color: #007bff;
            color: white;
        }

        .table tbody tr.table-success {
            background-color: #d4edda;
        }

        .table tbody tr.table-danger {
            background-color: #f8d7da;
        }

        .btn-info {
            background-color: #17a2b8;
            border-color: #17a2b8;
        }

        .btn-info:hover {
            background-color: #138496;
            border-color: #117a8b;
        }

        .btn-warning {
            background-color: #ffc107;
            border-color: #ffc107;
        }

        .btn-warning:hover {
            background-color: #e0a800;
            border-color: #d39e00;
        }

        .btn-danger {
            background-color: #dc3545;
            border-color: #dc3545;
        }

        .btn-danger:hover {
            background-color: #c82333;
            border-color: #bd2130;
        }

        .container {
            max-width: 1200px;
        }

        h1 {
            font-size: 2.5rem;
            font-weight: 600;
        }
    </style>
</head>

<div class="container mt-5">
    <h1 class="text-center mb-4">Distribution's List</h1>

    <table class="table table-bordered table-hover">
        <thead>
            <tr>
                <th>ID</th>
                <th>Commentaire</th>
                <th>Statut de lecture</th>
                <th>Deadline</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notifications as $notification)
                <tr class="{{ $notification->read_status ? 'table-success' : 'table-danger' }}">
                    <td>{{ $notification->id }}</td>
                    <td>{{ $notification->commentaire }}</td>
                    <td>{{ $notification->read_status ? 'Lue' : 'Non lue' }}</td>
                    <td>{{ $notification->deadline }}</td>
                    <td>
                        <a href="{{ route('utilisateur.notifisshow', $notification->id) }}" class="btn btn-info btn-sm">Afficher</a>
                        <a href="{{ route('utilisateur.notifisedit', $notification->id) }}" class="btn btn-warning btn-sm">Éditer</a>
                        <form action="{{ route('utilisateur.notifisdestroy', $notification->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm">Supprimer</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
