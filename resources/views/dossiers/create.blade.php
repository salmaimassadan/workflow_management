@extends('layout')
@section('content')
@section('title', 'Create Dossier')
@section('breadcrumb', 'Create Dossier')

<head>
    <title>Create Dossier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>

<div class="container">
    <div class="row" style="margin-top: 20px;">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>Create Dossier</h3>
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
                    <form action="{{ route('dossiers.store') }}" method="POST">
                        @csrf
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" id="title" value="{{ old('title') }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description">{{ old('description') }}</textarea>
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
                        <button type="submit" class="btn btn-outline-primary">Add Dossier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
