@extends('layout')

@section('title', 'Edit Dossier')
@section('breadcrumb', 'Edit Dossier');

@section('content')
<head>
    <title>Edit Dossier</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="container">
    <div class="row" style="margin-top: 20px;">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>Edit Dossier</h3>
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

                    <form action="{{ route('dossiers.update', $dossier->id) }}" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="form-group">
                            <label for="title">Title</label>
                            <input type="text" name="title" class="form-control" id="title" value="{{ old('title', $dossier->title) }}">
                        </div>
                        <div class="form-group">
                            <label for="description">Description</label>
                            <textarea name="description" class="form-control" id="description">{{ old('description', $dossier->description) }}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Available Courrier References</label>
                            <div class="mb-3">
                                @foreach($courriers as $courrier)
                                    <div class="form-check">
                                        <input 
                                            type="checkbox" 
                                            name="courrier_ids[]" 
                                            class="form-check-input" 
                                            id="courrier_{{ $courrier->id }}" 
                                            value="{{ $courrier->id }}"
                                            {{ $dossier->courriers->contains($courrier) ? 'checked' : '' }}
                                        >
                                        <label class="form-check-label" for="courrier_{{ $courrier->id }}">{{ $courrier->reference }}</label>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                        <button type="submit" class="btn btn-outline-primary">Update Dossier</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
