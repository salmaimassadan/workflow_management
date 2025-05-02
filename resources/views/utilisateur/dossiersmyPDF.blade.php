<!DOCTYPE html>
<html>
<head>
    <title>Dossiers PDF</title>
</head>
<body>
    <h1>Dossiers List</h1>
    <table>
        <thead>
            <tr>
                <th>Title</th>
                <th>Description</th>
            </tr>
        </thead>
        <tbody>
            @foreach($dossiers as $dossier)
                <tr>
                    <td>{{ $dossier->title }}</td>
                    <td>{{ $dossier->description }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
