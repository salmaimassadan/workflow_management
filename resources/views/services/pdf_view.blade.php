<!DOCTYPE html>
<html>
<head>
    <title>Details of service</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>Details of service</h1>
    <table>
        <tr>
            <th>ID</th>
            <td>{{ $service->id }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $service->name }}</td>
        </tr>
        <tr>
            <th>Description</th>
            <td>{{ $service->description }}</td>
        </tr>
    </table>
</body>
</html>
