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
    <h1>Courriers List</h1>
    <table>
        <thead>
            <tr>
                <th>#</th>
                <th>Reference</th>
                <th>Content</th>
                <th>Subject</th>
                <th>Type</th>
                <th>Sender</th>
                <th>Recipient</th>
                <th>Document</th>
                <th>Status</th>
                <th>Added at</th>
            </tr>
        </thead>
        <tbody>
            @foreach($notifications as $notification)
                <tr>
                    <td>{{ $notification->courrier->reference }}</td>
                    <td>{{ $notification->courrier->content }}</td>
                    <td>{{ $notification->courrier->subject }}</td>
                    <td>{{ $notification->courrier->type }}</td>
                    <td>{{ $notification->courrier->sender }}</td>
                    <td>{{ $notification->courrier->recipient }}</td>
                    <td>
                        @if ($notification->courrier->document)
                            <a href="{{ asset('storage/' . $notification->courrier->document) }}" target="_blank">View Document</a>
                        @else
                            No Document
                        @endif
                    </td>
                    <td>{{ $notification->courrier->status }}</td>
                    <td>{{ $notification->courrier->created_at }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div class="footer">
            <p>&copy; {{ date('Y') }} C2M. All rights reserved.</p>
        </div>
</body>
</html>
