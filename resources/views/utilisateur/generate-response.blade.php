@extends('utilisateur.layout')


@section('content')
<div class="container">
    <h1>Generate Response</h1>
    <form action="{{ route('generate.response') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="prompt">Enter Prompt:</label>
            <textarea id="prompt" name="prompt" class="form-control" rows="5"></textarea>
        </div>
        <button type="submit" class="btn btn-primary">Generate</button>
    </form>
</div>
@endsection
