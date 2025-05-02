<!DOCTYPE html>
<html>
<head>
    <title>List of Courriers</title>
    <style>
        body { font-family: Arial, sans-serif; }
        .container { width: 100%; margin: auto; }
        .header, .footer { text-align: center; }
        .content { margin-top: 20px; }
        .content h2 { text-align: center; }
        .details { margin-top: 20px; }
        .details th, .details td { padding: 5px; text-align: left; }
    </style>
</head>
<body>
    <h1>Notifications</h1>
    <table>
        <thead>
            <tr>
                <th>Reference</th>
                <th>Content</th>
                <th>Type</th>
                <th>Sender</th>
                <th>Recipient</th>
                <th>Status</th>
                <th>Added At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($notifications as $notification)
                <tr>
                    <td>{{ $notification->courrier->reference }}</td>
                    <td>{{ $notification->courrier->content }}</td>
                    <td>{{ $notification->courrier->type }}</td>
                    <td>{{ $notification->courrier->sender }}</td>
                    <td>{{ $notification->courrier->recipient }}</td>
                    <td>{{ $notification->courrier->status }}</td>
                    <td>{{ $notification->courrier->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>

    <h1>Courriers Created by You</h1>
    <table>
        <thead>
            <tr>
                <th>Reference</th>
                <th>Content</th>
                <th>Type</th>
                <th>Status</th>
                <th>Added At</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($courriersCreatedByEmployee as $courrier)
                <tr>
                    <td>{{ $courrier->reference }}</td>
                    <td>{{ $courrier->content }}</td>
                    <td>{{ $courrier->type }}</td>
                    <td>{{ $courrier->status }}</td>
                    <td>{{ $courrier->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>