<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dossiers Report</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 20px;
        }
        .container {
            width: 100%;
            margin: 0 auto;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th, .table td {
            border: 1px solid #ddd;
            padding: 8px;
        }
        .table th {
            background-color: #f2f2f2;
            text-align: left;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        h1 {
            margin: 0;
            font-size: 24px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>Dossiers Report</h1>
        </div>
        
        <table class="table">
            <thead>
                <tr>
                    <th>Reference</th>
                    <th>Title</th>
                    <th>Description</th>
                    <th>Courrier References</th>
                </tr>
            </thead>
            <tbody>
                @foreach($dossiers as $dossier)
                    <tr>
                        <td>{{ $dossier->reference }}</td>
                        <td>{{ $dossier->title }}</td>
                        <td>{{ $dossier->description }}</td>
                        <td>
                            @if($dossier->courriers->isNotEmpty())
                                <ul>
                                    @foreach($dossier->courriers as $courrier)
                                        <li>{{ $courrier->reference }}</li>
                                    @endforeach
                                </ul>
                            @else
                                No courriers
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</body>
</html>
