<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Dossier;
use App\Models\Courrier;
use App\Models\Notification;
use Illuminate\Support\Facades\Auth;
use Smalot\PdfParser\Parser;
use Barryvdh\DomPDF\Facade\Pdf;

class DossierController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth()->user();
        $userId = Auth::id();

        // Get the search term from the request
        $searchTerm = $request->input('search');

        // Query the dossiers with the search term
        $dossiers = Dossier::when($searchTerm, function ($query, $searchTerm) {
            return $query->where('title', 'like', "%{$searchTerm}%")
                         ->orWhere('description', 'like', "%{$searchTerm}%")
                         ->orWhereHas('courriers', function ($query) use ($searchTerm) {
                             $query->where('reference', 'like', "%{$searchTerm}%");
                         });
        })->paginate(10); // Adjust the number as needed

        $courriers = Courrier::all();
        $notifications = Notification::where('user_id', $userId)
            ->where('read_status', 0)
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        return view('dossiers.index', compact('dossiers', 'user', 'notifications', 'courriers'));
    }

    public function show(Dossier $dossier)
    {   
        $user = auth()->user();
        $userId = Auth::id();

        $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();
        
        $dossier->load('courriers'); 
        return view('dossiers.show', compact('dossier', 'user', 'notifications'));
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

        $courriers = Courrier::all();
        return view('dossiers.create', compact('courriers', 'user', 'notifications'));
    }

    public function store(Request $request)
    {
        // Generate a unique reference
        $reference = 'DOSS-' . strtoupper(uniqid());

        // Validate the request
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'courrier_refs' => 'nullable|array',
            'courrier_refs.*' => 'exists:courriers,reference',
        ]);

        // Create the dossier with the reference
        $dossier = Dossier::create([
            'reference' => $reference,
            'title' => $request->title,
            'description' => $request->description,
        ]);

        // Handle selected courriers
        if ($request->has('courrier_refs')) {
            $references = $request->courrier_refs;

            // Find courriers by reference and attach to the dossier
            $courriers = Courrier::whereIn('reference', $references)->get();
            $dossier->courriers()->attach($courriers);
        }

        return redirect()->route('dossiers.index')->with('success', 'Dossier created successfully.');
    }

    public function edit(Dossier $dossier)
    {   
        $user = auth()->user();
        $userId = Auth::id();

        $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();

        $courriers = Courrier::all();

        // Convert the courrier_refs to an array if it's a string or null
        $dossier->courrier_refs = explode(', ', $dossier->courrier_refs ?? '');

        return view('dossiers.edit', compact('dossier', 'courriers', 'user', 'notifications'));
    }

    public function update(Request $request, Dossier $dossier)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'courrier_refs' => 'nullable|array',
            'courrier_refs.*' => 'exists:courriers,reference',
        ]);

        $dossier->update($request->only('title', 'description'));

        // Sync the courriers
        if ($request->has('courrier_refs')) {
            $references = $request->courrier_refs;
            $courriers = Courrier::whereIn('reference', $references)->get();
            $dossier->courriers()->sync($courriers);
        }

        return redirect()->route('dossiers.index')->with('success', 'Dossier updated successfully.');
    }

    public function destroy(Dossier $dossier)
    {
        $dossier->delete();
        return redirect()->route('dossiers.index')->with('success', 'Dossier deleted successfully.');
    }
    public function generatePDF()
{
    $dossiers = Dossier::all();
    $pdf = PDF::loadView('dossiers.myPDF', ['dossiers' => $dossiers]);
    return $pdf->download('dossiers.pdf');
}
}
