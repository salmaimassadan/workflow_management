<!DOCTYPE html>
<html>
<head>
    <title>Details of User</title>
    <style>
        body { font-family: Arial, sans-serif; }
        table { width: 100%; border-collapse: collapse; }
        th, td { border: 1px solid #ddd; padding: 8px; }
        th { background-color: #f2f2f2; }
        h1 { text-align: center; }
    </style>
</head>
<body>
    <h1>Details of User</h1>
    <table>
        <tr>
            <th>ID</th>
            <td>{{ $employee->id }}</td>
        </tr>
        <tr>
            <th>First Name</th>
            <td>{{ $employee->firstname }}</td>
        </tr>
        <tr>
            <th>Name</th>
            <td>{{ $employee->name }}</td>
        </tr>
        <tr>
            <th>Email</th>
            <td>{{ $employee->email }}</td>
        </tr>
        <tr>
            <th>Password</th>
            <td>**********</td> <!-- Placeholder for security -->
        </tr>
        <tr>
            <th>Phone</th>
            <td>{{ $employee->phone }}</td>
        </tr>
        <tr>
            <th>Service</th>
            <td>{{ $employee->service->name }}</td> 
        </tr>
        <tr>
            <th>Role</th>
            <td>{{ $employee->role }}</td> 
        </tr>
        <tr>
            <th>Image</th>
            <td>
                @if($employee->image)
                    <img src="{{ asset('storage/' . $employee->image) }}" alt="Image" width="100">
                @else
                    No image available
                @endif
            </td>
        </tr>
    </table>
</body>
</html>
