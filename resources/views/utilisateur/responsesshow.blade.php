@extends('utilisateur.layout')

@section('content')
    <h1>Generated Response</h1>
    <div>
        <p>{{ $response }}</p>
    </div>
    <a href="{{ route('utilisateur.show') }}" class="btn btn-primary">Use this response</a>
@endsection
