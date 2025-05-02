@extends('utilisateur.layout')

@section('title', 'Directories')
@section('breadcrumb', 'Create New Directory')
@section('content')
<head>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <style>
        .card {
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .card-header {
            background-color: #007bff;
            color: white;
            border-bottom: 1px solid #007bff;
            border-top-left-radius: 8px;
            border-top-right-radius: 8px;
        }

        .card-body {
            padding: 2rem;
        }

        .form-label {
            font-weight: bold;
            color: #333;
        }

        .form-control {
            border-radius: 4px;
        }

        .btn-primary {
            background-color: #007bff;
            border: none;
            border-radius: 4px;
            padding: 0.5rem 1.5rem;
        }

        .btn-primary:hover {
            background-color: #0056b3;
        }

        .btn-primary:focus, .btn-primary:active {
            box-shadow: none;
            outline: none;
        }
    </style>
</head>

<div class="container mt-5">
    <h1 class="mb-4">Create New Dossier</h1>

    <form action="{{ route('utilisateur.dossiersstore') }}" method="POST">
        @csrf
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">Dossier Details</h5>
            </div>
            <div class="card-body">
                <div class="form-group mb-3">
                    <label for="title" class="form-label">Title</label>
                    <input type="text" name="title" id="title" class="form-control" required>
                </div>

                <div class="form-group mb-3">
                    <label for="description" class="form-label">Description</label>
                    <textarea name="description" id="description" class="form-control" rows="4"></textarea>
                </div>

                <div class="form-group">
                            <label for="courrier_refs">Courrier References</label>
                            <div id="courrierList">
                                @foreach($courriers as $courrier)
                                    <div class="form-check">
                                        <input type="checkbox" name="courrier_refs[]" class="form-check-input" id="courrier_{{ $courrier->id }}" value="{{ $courrier->reference }}">
                                        <label class="form-check-label" for="courrier_{{ $courrier->id }}">{{ $courrier->reference }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                <div class="d-flex justify-content-end">
                    <button type="submit" class="btn btn-primary">Create Dossier</button>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection
