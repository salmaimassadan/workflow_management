<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courrier;
use App\Models\Service;
use App\Models\Employee;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use Illuminate\Support\Facades\Storage;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Smalot\PdfParser\Parser;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendMail;
use Illuminate\Support\Facades\Validator;
use App\Mail\CourrierNotificationMail;
use Illuminate\Http\Response;
use Illuminate\Support\Str;





class CourrierController extends Controller
{
    public function index(Request $request)
{
    $query = Courrier::query(); // Start building the query

    $search = $request->get('search', '');

    // Apply search filter on reference
    $query->when($search, function($query) use ($search) {
        return $query->where('reference', 'like', '%' . $search . '%');
    });
    
    // Apply status filter
    if ($request->has('status') && $request->status) {
        $query->where('status', $request->status);
    }

    // Paginate the query results
    $courriers = $query->paginate(10);

    // Message when no results are found
    $message = $courriers->isEmpty() ? "Aucun courrier trouvé pour les critères sélectionnés." : null;

    // Count statistics for courriers
    $countRead = Courrier::where('status', 'lu')->count();
    $countUnread = Courrier::where('status', 'non lu')->count();
    $countUrgent = Courrier::where('status', 'urgent')->count();
    $countArchived = Courrier::where('status', 'archivé')->count();
    $countCompleted = Courrier::where('status', 'traité')->count();

    // Fetch user-specific notifications
    $userId = Auth::id();
    $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();

    // Get all services and employees
    $services = Service::all();
    $employees = Employee::all();

    // Fetch the current authenticated user
    $user = auth()->user();

    // Return the view with all data
    return view('courriers.index', compact(
        'courriers', 'countRead', 'countUnread', 'countUrgent', 'countArchived', 'countCompleted', 
        'services', 'employees', 'user', 'notifications', 'message'
    ));
}

public function employeesByService($serviceId)
{
    // Validate the existence of the service
    $service = Service::findOrFail($serviceId);

    // Retrieve the employees associated with this service
    $employees = Employee::where('service_id', $serviceId)->get();

    // Return the employees as JSON
    return response()->json($employees);
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

        return view('courriers.create', compact('user', 'notifications'));
    }


    public function store(Request $request)
{
    // Validate the request data
    $validatedData = $request->validate([
        'type' => 'required|string',
        'subject' => 'required|string',
        'content' => 'required|string',
        'status' => 'required|string',
        'sender' => 'required|string',
        'recipient' => 'required|string',
        'created_at' => 'required|date',
        'document' => 'nullable|mimes:pdf,png,jpg,jpeg|max:10000',
        'service_id' => 'nullable|exists:services,id',
        'user_ids' => 'nullable|array',
        'user_ids.*' => 'exists:employees,id',
        'deadline' => 'nullable|date',
    ]);

    $reference = 'COURR-' . strtoupper(uniqid()); // Generate a unique reference

    try {
        // Handle file upload
        $filePath = $request->hasFile('document') ? $request->file('document')->store('documents', 'public') : null;

        // Create a new courrier
        $courrier = Courrier::create([
            'reference' => $reference,
            'type' => $validatedData['type'],
            'subject' => $validatedData['subject'],
            'content' => $validatedData['content'],
            'status' => $validatedData['status'],
            'sender' => $validatedData['sender'],
            'recipient' => $validatedData['recipient'],
            'created_at' => $validatedData['created_at'],
            'document' => $filePath,
        ]);

        // Handling service_id and user_ids
        $serviceId = $validatedData['service_id'] ?? null;
        $userIds = $validatedData['user_ids'] ?? [];
        $deadline = $validatedData['deadline'] ?? null;

        $employees = [];

        if (empty($userIds) && $serviceId) {
            // Notify all users in the service if no specific users are selected
            $employees = Employee::where('service_id', $serviceId)->get();
        } elseif (!empty($userIds)) {
            // Notify selected users
            $employees = Employee::whereIn('id', $userIds)->get();
        }

        foreach ($employees as $employee) {
            Notification::create([
                'courrier_id' => $courrier->id,
                'service_id' => $serviceId,
                'user_id' => $employee->id, // Ensure this is mapped correctly
                'commentaire' => 'Vous avez une nouvelle tâche.',
                'read_status' => 'non lu',
                'deadline' => $deadline,
            ]);

            // Send email notification
            Mail::to($employee->email)->send(new CourrierNotificationMail($courrier, $employee));
        }

        return redirect()->route('courriers.index')->with('success', 'Courrier envoyé avec succès !');
    } catch (\Illuminate\Database\QueryException $e) {
        // Handle database errors, such as foreign key violations
        return redirect()->back()->withErrors(['message' => 'Une erreur est survenue lors de l\'envoi du courrier.']);
    } catch (\Exception $e) {
        // Handle other potential exceptions
        return redirect()->back()->withErrors(['message' => 'Une erreur inattendue est survenue.']);
    }
}



public function processUpload(Request $request)
{   
    $user = auth()->user();
    $userId = Auth::id();

    $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();

    if ($request->hasFile('document')) {
        $file = $request->file('document');
        $filePath = $file->store('documents', 'public');

        // Ajouter le code d'extraction des données ici

        $extractedData = 'Extracted text from the document'; // Exemple de données extraites

        return view('courriers.create', [
            'extractedData' => $extractedData,
            'user' => $user,
            'notifications' => $notifications
        ]);
    }

    return redirect()->route('upload.form')->withErrors(['document' => 'Le document est requis.']);
}


public function send(Request $request, $courrierId)
{
    $courrier = Courrier::findOrFail($courrierId);

    $notificationData = $request->validate([
        'service_id' => 'nullable|exists:services,id',
        'user_ids' => 'nullable|array',
        'user_ids.*' => 'exists:employees,id',
        'commentaire' => 'nullable|string',
        'deadline' => 'nullable|date',
        'read_status' => 'required|string|in:non lu,lu',
    ]);

    if (!empty($notificationData['user_ids'])) {
        foreach ($notificationData['user_ids'] as $userId) {
            Notification::create([
                'courrier_id' => $courrier->id,
                'service_id' => $notificationData['service_id'],
                'user_id' => $userId,
                'commentaire' => $notificationData['commentaire'],
                'deadline' => $notificationData['deadline'],
                'read_status' => $notificationData['read_status'],
            ]);
        }
    } else {
        // Retourner en arrière avec un message d'erreur si aucun utilisateur n'est sélectionné
        return redirect()->back()->withErrors(['message' => 'No users selected for notification.']);
    }

    // Redirection avec un message de succès
    return redirect()->route('courriers.show', $courrierId)
                     ->with('success', 'Courrier envoyé avec succès!');
}

public function update(Request $request, $id)
{
    $request->validate([
        'type' => 'required|string',
        'subject' => 'required|string',
        'content' => 'required|string',
        'status' => 'required|string',
        'sender' => 'required|string',
        'recipient' => 'required|string',
        'created_at' => 'required|date',
        'document' => 'nullable|mimes:pdf,png,jpg,jpeg|max:10000',
    ]);

    $courrier = Courrier::findOrFail($id);

    $filePath = $courrier->document;
    if ($request->hasFile('document')) {
        Storage::disk('public')->delete($filePath);
        $file = $request->file('document');
        $filePath = $file->store('documents', 'public');
    }

    $courrier->update([
        'type' => $request->type,
        'subject' => $request->subject,
        'content' => $request->input('content'),
        'status' => $request->status,
        'sender' => $request->sender,
        'recipient' => $request->recipient,
        'created_at' => $request->created_at,
        'document' => $filePath,
    ]);
    
    return redirect()->route('courriers.index')->with('success', 'Courrier mis à jour avec succès!');
}
public function edit($id)
{   
    $user = auth()->user();
        $userId = Auth::id();

        $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();

    $courrier = Courrier::findOrFail($id);
    return view('courriers.edit', compact('courrier', 'user', 'notifications'));
}
public function show($id)
{
    $courrier = Courrier::findOrFail($id);

    $user = auth()->user();
    $userId = Auth::id();
    $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();

    return view('courriers.show', compact('courrier', 'user', 'notifications'));
}

    public function destroy($id)
    {
        $courrier = Courrier::findOrFail($id);
        Storage::disk('public')->delete($courrier->document);
        $courrier->delete();
        return redirect()->route('courriers.index')->with('success', 'Courrier supprimé avec succès.');
    }

    public function upload(Request $request)
{   $user = auth()->user();
    $userId = Auth::id();
    $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();
    $request->validate([
        'document' => 'required|file|mimes:pdf,jpeg,png,jpg|max:2048',
    ]);

    if ($request->hasFile('document')) {
        $document = $request->file('document');
        $path = Storage::disk('public')->putFile('documents', $document);

        $extension = $document->getClientOriginalExtension();

        if (in_array($extension, ['png', 'jpg', 'jpeg'])) {
            $ocr = new TesseractOCR(Storage::disk('public')->path($path));
            $text = $ocr->run();
        } elseif ($extension == 'pdf') {
            $parser = new Parser();
            $pdf = $parser->parseFile(Storage::disk('public')->path($path));
            $text = $pdf->getText();
        } else {
            return response('Invalid file type', Response::HTTP_UNSUPPORTED_MEDIA_TYPE);
        }

        // Return the view with extracted data
        return view('courriers.create', [
            'extractedData' => $text,
            'user' => $user,
            'notifications' => $notifications,
        ]);    }

    return redirect()->route('upload.form')->withErrors(['document' => 'Le document est requis.']);
}
public function generatePDF()
{
    $courriers = Courrier::all();
    $pdf = PDF::loadView('courriers.myPDF', ['courriers' => $courriers]);
    return $pdf->download('courriers.pdf');
}

}
