<!-- resources/views/utilisateur/reply.blade.php -->
@extends('utilisateur.layout')

@section('content')
<div class="container">
    <h2>Generate Response for Courrier: {{ $courrier->reference }}</h2>
    
    @if ($errors->any())
        <div class="alert alert-danger">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('courriers.generateResponse', $courrier->id) }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="template">Choose a Template:</label>
            <select name="template_id" id="template" class="form-control" required>
                <option value="" disabled selected>Select a template</option>
                @foreach($templates as $template)
                    <option value="{{ $template->id }}">{{ $template->title }}</option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">Generate Response</button>
    </form>

    @if(isset($responseContent))
    <div class="form-group mt-4">
        <label for="responseContent">Generated Response:</label>
        <textarea id="responseContent" class="form-control" rows="10">{{ $responseContent }}</textarea>
    </div>
    @endif
</div>
@endsection