@extends('utilisateur.layout')

@section('title', 'Directories')
@section('breadcrumb', 'Show Directory')
@section('content')
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .card {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            margin-bottom: 2rem;
        }

        .card-header {
            background-color: #007bff;
            color: white;
            border-bottom: 1px solid #007bff;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .btn-secondary {
            background-color: #6c757d;
            border: none;
            border-radius: 4px;
            padding: 0.5rem 1.5rem;
        }

        .btn-secondary:hover {
            background-color: #5a6268;
        }

        .btn-secondary:focus, .btn-secondary:active {
            box-shadow: none;
            outline: none;
        }

        .list-group-item {
            border: none;
            border-bottom: 1px solid #ddd;
            border-radius: 4px;
            padding: 10px;
            margin-bottom: -1px;
        }

        .list-group-item:last-child {
            border-bottom: none;
        }
    </style>
</head>

<div class="container mt-5">
    <div class="card">
        <div class="card-header">
            <h2 class="mb-0">{{ $dossier->title }}</h2>
        </div>
        <div class="card-body">
            <p class="mb-4">{{ $dossier->description }}</p>

            <h4>Courriers</h4>
            <ul class="list-group">
                @foreach($dossier->courriers as $courrier)
                    <li class="list-group-item">{{ $courrier->reference }}</li>
                @endforeach
            </ul>

            <div class="mt-4">
                <a href="{{ route('utilisateur.dossiersindex') }}" class="btn btn-secondary">
                    <i class="bi bi-arrow-left"></i> Back to Directories
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
