@extends('utilisateur.layout')

@section('title', 'Responses')
@section('breadcrumb', 'Generate Response')

@section('content')
<head>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .container {
            max-width: 720px;
            background-color: #ffffff;
            padding: 40px;
            border-radius: 10px;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            margin-top: 50px;
        }

        h1 {
            font-size: 2rem;
            margin-bottom: 1.5rem;
            font-weight: 700;
            text-align: center;
            color: #343a40;
            border-bottom: 2px solid #dee2e6;
            padding-bottom: 15px;
        }

        .form-group label {
            font-weight: 600;
            color: #495057;
            font-size: 1.1rem;
        }

        .form-control {
            border-radius: 5px;
            font-size: 1rem;
            padding: 12px;
            background-color: #f8f9fa;
            border: 1px solid #ced4da;
        }

        .form-control:focus {
            box-shadow: 0 0 5px rgba(0, 123, 255, 0.5);
            border-color: #80bdff;
        }

        .btn-primary {
            background-color: #007bff;
            border-color: #007bff;
            padding: 12px 24px;
            font-size: 1rem;
            border-radius: 5px;
        }

        .btn-primary:hover {
            background-color: #0056b3;
            border-color: #004085;
        }

        .d-flex {
            justify-content: flex-end;
            margin-top: 30px;
        }

        /* Additional Spacing for the Textarea */
        textarea {
            resize: vertical;
            min-height: 150px;
        }

        /* Improve mobile responsiveness */
        @media (max-width: 768px) {
            .container {
                padding: 20px;
            }

            h1 {
                font-size: 1.5rem;
            }

            .btn-primary {
                width: 100%;
            }
        }
    </style>
</head>

<div class="container">
    <h1>Generate a Response</h1>

    <form action="{{ route('responses.save', $courrier->id) }}" method="POST">
        @csrf
        <div class="form-group mb-4">
            <label for="content">Response:</label>
            <textarea id="content" name="content" class="form-control" rows="10">{{ old('content', $generatedContent) }}</textarea>
        </div>
        <div class="d-flex">
            <button type="submit" class="btn btn-primary">Save Response</button>
        </div>
    </form>
</div>
@endsection
