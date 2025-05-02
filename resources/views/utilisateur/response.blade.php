@extends('utilisateur.layout')

@section('content')
<div class="container">
    <div class="row justify-content-center">
        <div class="col-md-8">
            <div class="card">
                <div class="card-header">Generated Response</div>

                <div class="card-body">
                    <h5>Response for Courrier: {{ $courrier->reference }}</h5>
                    <p>{{ $text }}</p>

                    <a href="{{ route('utilisateur.show', $courrier->id) }}" class="btn btn-secondary">Back to Courrier</a>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
