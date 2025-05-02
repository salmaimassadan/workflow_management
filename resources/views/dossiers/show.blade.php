@extends('layout')

@section('title', 'Dossier Details')
@section('breadcrumb', 'Dossier Details')

@section('content')
<head>
    <title>Dossier's Details</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<div class="container">
    <div class="row" style="margin-top: 20px;">
        <div class="col-md-8 offset-md-2">
            <div class="card">
                <div class="card-header">
                    <h3>Dossier Details</h3>
                </div>
                <div class="card-body">
                    <p><strong>Reference:</strong> {{ $dossier->reference }}</p>
                    <p><strong>Title:</strong> {{ $dossier->title }}</p>
                    <p><strong>Description:</strong> {{ $dossier->description }}</p>
                    <p><strong>Courrier References:</strong></p>
                    @if($dossier->courriers->isNotEmpty())
                        <ul>
                            @foreach($dossier->courriers as $courrier)
                                <li>{{ $courrier->reference }}</li>
                            @endforeach
                        </ul>
                    @else
                        <p>No courriers associated with this dossier.</p>
                    @endif
                </div>
                <div class="card-footer">
                    <a href="{{ route('dossiers.edit', $dossier->id) }}" class="btn btn-outline-warning">Edit</a>
                    <form action="{{ route('dossiers.destroy', $dossier->id) }}" method="POST" class="d-inline-block" onsubmit="return confirm('Are you sure you want to delete this dossier?');">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-outline-danger">Delete</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
