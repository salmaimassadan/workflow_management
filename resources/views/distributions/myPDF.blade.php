<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Distributions List</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            font-size: 12px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }
        table, th, td {
            border: 1px solid black;
        }
        th, td {
            padding: 8px;
            text-align: left;
        }
        th {
            background-color: #f2f2f2;
        }
        .header {
            text-align: center;
            margin-bottom: 20px;
        }
        .header h2 {
            margin: 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <h2>Distributions List</h2>
        <p>Generated on: {{ \Carbon\Carbon::now()->format('Y-m-d H:i:s') }}</p>
    </div>

    <table>
        <thead>
            <tr>
                <th>Courrier Reference</th>
                <th>Sent To</th>
                <th>Service</th>
                <th>Commentaire</th>
                <th>Read Status</th>
                <th>Deadline</th>
                <th>Created By</th>
            </tr>
        </thead>
        <tbody>
            @foreach($distributions as $distribution)
                <tr>
                    <td>{{ $distribution->courrier->reference }}</td>
                    <td>{{ $distribution->employee ? $distribution->employee->name : 'N/A' }}</td>
                    <td>{{ $distribution->service ? $distribution->service->name : 'N/A' }}</td>
                    <td>{{ $distribution->commentaire }}</td>
                    <td>{{ $distribution->read_status ? 'Read' : 'Unread' }}</td>
                    <td>{{ $distribution->deadline ? $distribution->deadline->format('Y-m-d') : 'No Deadline' }}</td>
                    <td>{{ $distribution->creator ? $distribution->creator->name : 'Unknown' }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
