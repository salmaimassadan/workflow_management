<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Employee;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;


use Barryvdh\DomPDF\Facade\Pdf;


class ServiceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) // Ajoutez Request ici
    {
        $search = $request->get('search', '');

        $services = Service::when($search, function($query) use ($search) {
            return $query->where('name', 'like', '%' . $search . '%')
                         ->orWhere('description', 'like', '%' . $search . '%');
        })->paginate(10);

        $user = auth()->user();
        $userId = Auth::id();

        $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();
        return view('services.index', compact('services', 'user', 'notifications'));
    }


    public function create()
    {   

        $user = auth()->user();
        $userId = Auth::id();

        $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();
        return view('services.create', compact('user', 'notifications'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        Service::create($request->all());

        return redirect()->route('services.index')
                         ->with('success', 'Service created successfully.');
    }

    public function show(Service $service)
    {   
        $user = auth()->user();
        $userId = Auth::id();

        $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();
        return view('services.show', compact('service', 'user', 'notifications'));
    }

    public function edit(Service $service)
    {   
        $user = auth()->user();
        $userId = Auth::id();

        $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();
        return view('services.edit', compact('service', 'user', 'notifications'));
    }

    public function update(Request $request, Service $service)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ]);

        $service->update($request->all());

        return redirect()->route('services.index')
                         ->with('success', 'Service updated successfully.');
    }

    public function destroy(Service $service)
    {
        $service->delete();

        return redirect()->route('services.index')
                         ->with('success', 'Service deleted successfully.');
    }

public function downloadPdf()
    {
        $services = Service::all(); 

        $pdf = PDF::loadView('services.myPDF', ['services' => $services]);

        return $pdf->download('services_list.pdf');
    }

    public function downloadPdf_view($id)
    {
        $service = Service::findOrFail($id);

        $pdf = PDF::loadView('services.pdf_view', ['service' => $service]);

        return $pdf->download('service_' . $service->id . '_details.pdf');
    }

    public function getUsers($id)
    {
        $service = Service::find($id);

        if (!$service) {
            return response()->json(['error' => 'Service not found'], 404);
        }

        $employees = Employee::where('service_id', $id)->get();

        return response()->json(['employees' => $employees]);
    }



}