@extends('layout')

@section('title', 'Extracted Data')
@section('breadcrumb', 'Extracted Data')

@section('content')
<div class="container mt-4">
    <h3>Extracted Data</h3>
    <pre>{{ $extractedData }}</pre>
</div>
@endsection
