<!DOCTYPE html>
<html>
<head>
    <title>User's List</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>User's List</h1>
    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>First Name</th>
                <th>Name</th>
                <th>Email</th>
                <th>Phone</th>
                <th>Service</th>
                <th>Role</th>
                <th>Image</th>
            </tr>
        </thead>
        <tbody>
            @foreach($employees as $employee)
                <tr>
                    <td>{{ $employee->id }}</td>
                    <td>{{ $employee->firstname }}</td>
                    <td>{{ $employee->name }}</td>
                    <td>{{ $employee->email }}</td>
                    <td>{{ $employee->phone }}</td>
                    <td>{{ $employee->service->name }}</td>
                    <td>{{ $employee->role }}</td>
                    <td>
                        @if($employee->image)
                            <img src="{{ asset('storage/' . $employee->image) }}" alt="Image" width="50">
                        @else
                            No Image
                        @endif
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>
