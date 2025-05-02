<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Service;
use App\Models\Employee;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Smalot\PdfParser\Parser;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;


class DistributionController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    $search = $request->get('search', '');

    $distributions = Notification::when($search, function ($query) use ($search) {
        return $query->where('commentaire', 'like', '%' . $search . '%')
                     ->orWhereHas('courrier', function ($q) use ($search) {
                         $q->where('subject', 'like', '%' . $search . '%');
                     });
    })->paginate(10);

    $user = auth()->user();
    $userId = Auth::id();

    $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();

    return view('distributions.index', compact('distributions', 'user', 'notifications'));
}


    
    public function show(Notification $distribution)
    {   
        $user = auth()->user();
        $userId = Auth::id();

        $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();
        return view('distributions.show', compact('distribution', 'user', 'notifications'));
    }

    public function edit(Notification $distribution)
    {   
        $user = auth()->user();
        $userId = Auth::id();

        $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();
        return view('distributions.edit', compact('distribution', 'user', 'notifications'));
    }

    public function update(Request $request, Notification $distribution)
{
    $request->validate([
        'courrier_id' => 'required|exists:courriers,id',
        'service_id' => 'nullable|exists:services,id',
        'user_id' => 'nullable|exists:employees,id',
        'commentaire' => 'required|string|max:255',
        'read_status' => 'required|boolean',
        'deadline' => 'nullable|date',
        'created_by' => 'required|exists:employees,id',
    ]);

    $distribution->update($request->all());

    return redirect()->route('distributions.index')
                     ->with('success', 'Distribution updated successfully.');
}


    public function destroy(Notification $distribution)
    {
        $distribution->delete();

        return redirect()->route('distributions.index')
                         ->with('success', 'Distribution deleted successfully.');
    }

public function downloadPdf()
    {
        $distributions = Notification::all(); 

        $pdf = PDF::loadView('distributions.myPDF', ['distributions' => $distributions]);

        return $pdf->download('distributions_list.pdf');
    }

    



}
