<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Models\Service;
use App\Models\Notification;
use App\Models\Courrier;
use Illuminate\Support\Facades\Auth;


use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;


class UserController extends Controller
{
    public function index(Request $request)
    {   

        $user = auth()->user();
        $userId = Auth::id();

        $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();

        $search = $request->input('search');
        $employees = Employee::with('service')
        ->when($search, function ($query, $search) {
            return $query->where('name', 'like', "%$search%")
                         ->orWhere('firstname', 'like', "%$search%")
                         ->orWhere('email', 'like', "%$search%");
        })->paginate(10);
        $user = auth()->user();
        $userId = Auth::id();

        $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();

    return view('employees.index', compact('employees', 'user', 'notifications'));
    }

    public function create()
    {
        $services = Service::all();
        $user = auth()->user();
        $userId = Auth::id();

        $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();
        return view('employees.create', compact('services', 'user', 'notifications'));
    }

    public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'firstname' => 'nullable|string|max:255',
        'email' => 'required|string|email|max:255|unique:employees',
        'password' => 'required|string|min:8',
        'phone' => 'nullable|string|max:20',
        'role' => 'required|string', 
        'service_id' => 'required|exists:services,id',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $data = $request->all();
    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('images', 'public');
        $data['image'] = $imagePath;
    }

    $data['password'] = bcrypt($request->password);

    Employee::create($data);

    return redirect()->route('employees.index')->with('success', 'Employee created successfully.');
}

    public function show($id)
    {
        $employee = Employee::findOrFail($id);
        $user = auth()->user();
        $userId = Auth::id();

        $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();
        return view('employees.show', compact('employee', 'user', 'notifications'));
    }

    public function edit($id)
    {
        
        $employee = Employee::findOrFail($id);
        $services = Service::all();
        $user = auth()->user();
        $userId = Auth::id();

        $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();
        return view('employees.edit', compact('employee', 'services', 'user', 'notifications'));
    }

    public function update(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'firstname' => 'nullable|string|max:255',
        'email' => 'required|string|email|max:255|unique:employees,email,'.$id,
        'phone' => 'nullable|string|max:20',
        'role' => 'required|string', 
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
    ]);

    $employee = Employee::findOrFail($id);

    $data = $request->all();
    if ($request->hasFile('image')) {
        // Delete the old image if it exists
        if ($employee->image) {
            Storage::disk('public')->delete($employee->image);
        }
        $imagePath = $request->file('image')->store('images', 'public');
        $data['image'] = $imagePath;
    }

    if ($request->filled('password')) {
        $data['password'] = bcrypt($request->password);
    } else {
        unset($data['password']);
    }

    $employee->update($data);

    return redirect()->route('employees.index')->with('success', 'Employee updated successfully.');
}


    public function destroy($id)
    {
        $employee = Employee::findOrFail($id);
        // Supprimer l'image associée
        if ($employee->image) {
            Storage::disk('public')->delete($employee->image);
        }
        $employee->delete();
        return redirect()->route('employees.index')->with('success', 'Employee deleted successfully.');
    }
    public function downloadPdf()
    {
        $employees = Employee::all(); 
        $pdf = PDF::loadView('employees.myPDF', ['employees' => $employees]);
        return $pdf->download('users_list.pdf');
    }

    public function downloadPdf_view($id)
    {
        $employee = Employee::findOrFail($id);
        $pdf = PDF::loadView('employees.pdf_view', ['employee' => $employee]);
        return $pdf->download('user_' . $employee->id . '_details.pdf');
    }
}
