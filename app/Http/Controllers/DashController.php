<?php

namespace App\Http\Controllers;

use App\Models\Courrier;
use App\Models\Employee;
use App\Models\Service;
use App\Models\Notification;
use App\Models\User;
use App\Models\Response;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;



class DashController extends Controller
{
    /**
     * Show the dashboard with filtered and paginated courriers.
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Http\JsonResponse
     */
    public function index(Request $request)
{
    // Dashboard counts
    $userCount = Employee::count();
    $courrierCount = Courrier::count();
    $serviceCount = Service::count();
    $user = auth()->user();
    $userId = Auth::id();
    
    // Notifications (unrelated but useful for the dashboard)
    $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();

    // --- COURRIERS Section ---
    // Query for courriers with filtering options
    $courrierQuery = Courrier::query();

    if ($request->has('search') && $request->search) {
        $courrierQuery->where('reference', 'like', '%' . $request->search . '%');
    }

    if ($request->has('status') && $request->status) {
        $courrierQuery->where('status', $request->status);
    }

    if ($request->has('date') && $request->date) {
        $courrierQuery->whereDate('created_at', $request->date);
    }

    // Fetch the latest 5 courriers
    $courriers = $courrierQuery->orderBy('created_at', 'desc')->limit(5)->get();

    // --- RESPONSES Section ---
    // Fetch all responses with creator and courrier relationships
    $responses = Response::with(['creator', 'courrier'])->get();

    // Group responses by courrier_id for classification
    $classifiedResponses = $responses->groupBy('courrier_id');

    // Pass data to the view
    return view('dashboard', [
        'user'=>$user,
        'userCount' => $userCount,
        'courrierCount' => $courrierCount,
        'serviceCount' => $serviceCount,
        'courriers' => $courriers,         // For Courrier table
        'notifications' => $notifications,
        'classifiedResponses' => $classifiedResponses,  // For Responses table
    ]);
}


}