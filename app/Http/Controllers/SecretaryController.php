<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Courrier;
use App\Models\Notification;
use App\Models\Service;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CourrierNotificationMail;
use Smalot\PdfParser\Parser;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;

class SecretaryController extends Controller
{
    // Show secretary dashboard
    public function dashboard()
{
    // Ensure that the user is authenticated as an employee
    $user = Auth::guard('employee')->user();

    if ($user) {
        $courriers = Courrier::where('user_id', $user->id)->get();
        $notifications = Notification::where('user_id', $user->id)
            ->where('read_status', 'non lu')
            ->get();
            return view('secretary.dashboard', compact('courriers', 'notifications', 'user'));
        } else {
        // Handle the case where the employee is not authenticated
        return redirect()->route('login')->with('error', 'Please log in to access the dashboard.');
    }
}

    // List  courriers
    public function index(Request $request)
{
    $user = Auth::guard('employee')->user(); 
    $unreadNotificationsCount = Notification::where('user_id', $user->id)
            ->where('read_status', 'non lu')
            ->count();
    // Initialize the notification query with user-based filters
    $notificationQuery = Notification::with('courrier')
        ->where('created_by', $user->id)
        ->orWhereHas('courrier', function($q) use ($user) {
        });

    // Apply search filter if present
    if ($request->filled('search')) {
        $search = $request->input('search');
        $notificationQuery->whereHas('courrier', function($q) use ($search) {
            $q->where('reference', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%")
              ->orWhere('subject', 'like', "%{$search}%")
              ->orWhere('type', 'like', "%{$search}%")
              ->orWhere('sender', 'like', "%{$search}%")
              ->orWhere('recipient', 'like', "%{$search}%");
        });
    }

    // Apply status filter if present
    if ($request->filled('status')) {
        $status = $request->input('status');
        $notificationQuery->whereHas('courrier', function($q) use ($status) {
            $q->where('status', $status);
        });
    }

    // Apply date filter if present
    if ($request->filled('date')) {
        $date = $request->input('date');
        $notificationQuery->whereHas('courrier', function($q) use ($date) {
            $q->whereDate('created_at', $date);
        });
    }

    // Paginate notifications
    $notifications = $notificationQuery->paginate(10);

    // Fetch courriers created by the employee
    $courriersCreatedByEmployee = Courrier::where('created_by', $user->id)->get();

    // Count various statuses for notifications
    $countRead = Notification::where('user_id', $user->id)->where('read_status', 'lu')->count();
    $countUnread = Notification::where('user_id', $user->id)->where('read_status', 'non lu')->count();
    $countUrgent = Notification::where('user_id', $user->id)
        ->whereHas('courrier', function($q) {
            $q->where('status', 'urgent');
        })->count();
    $countArchived = Notification::where('user_id', $user->id)
        ->whereHas('courrier', function($q) {
            $q->where('status', 'archivé');
        })->count();
    $countCompleted = Notification::where('user_id', $user->id)
        ->whereHas('courrier', function($q) {
            $q->where('status', 'traité');
        })->count();

    $services = Service::all();
    $employees = Employee::all();

    // Return view with compacted data
    return view('secretary.courriers', compact(
        'notifications', 
        'courriersCreatedByEmployee', 
        'countRead', 
        'countUnread', 
        'countUrgent', 
        'countArchived', 
        'countCompleted', 
        'services', 
        'employees', 
        'user',
        'unreadNotificationsCount'
    ));
}
public function index_2(Request $request)
{
    $user = Auth::guard('employee')->user(); 
    $unreadNotificationsCount = Notification::where('user_id', $user->id)
            ->where('read_status', 'non lu')
            ->count();
    // Initialize the notification query with user-based filters
    $notificationQuery = Notification::with('courrier')
        ->where('user_id', $user->id);
    // Apply search filter if present
    if ($request->filled('search')) {
        $search = $request->input('search');
        $notificationQuery->whereHas('courrier', function($q) use ($search) {
            $q->where('reference', 'like', "%{$search}%")
              ->orWhere('content', 'like', "%{$search}%")
              ->orWhere('subject', 'like', "%{$search}%")
              ->orWhere('type', 'like', "%{$search}%")
              ->orWhere('sender', 'like', "%{$search}%")
              ->orWhere('recipient', 'like', "%{$search}%");
        });
    }

    // Apply status filter if present
    if ($request->filled('status')) {
        $status = $request->input('status');
        $notificationQuery->whereHas('courrier', function($q) use ($status) {
            $q->where('status', $status);
        });
    }

    // Apply date filter if present
    if ($request->filled('date')) {
        $date = $request->input('date');
        $notificationQuery->whereHas('courrier', function($q) use ($date) {
            $q->whereDate('created_at', $date);
        });
    }

    // Paginate notifications
    $notifications = $notificationQuery->paginate(10);

    // Fetch courriers created by the employee
    $courriersCreatedByEmployee = Courrier::where('created_by', $user->id)->get();

    // Count various statuses for notifications
    $countRead = Notification::where('user_id', $user->id)->where('read_status', 'lu')->count();
    $countUnread = Notification::where('user_id', $user->id)->where('read_status', 'non lu')->count();
    $countUrgent = Notification::where('user_id', $user->id)
        ->whereHas('courrier', function($q) {
            $q->where('status', 'urgent');
        })->count();
    $countArchived = Notification::where('user_id', $user->id)
        ->whereHas('courrier', function($q) {
            $q->where('status', 'archivé');
        })->count();
    $countCompleted = Notification::where('user_id', $user->id)
        ->whereHas('courrier', function($q) {
            $q->where('status', 'traité');
        })->count();

    $services = Service::all();
    $employees = Employee::all();

    // Return view with compacted data
    return view('secretary.courriers', compact(
        'notifications', 
        'courriersCreatedByEmployee', 
        'countRead', 
        'countUnread', 
        'countUrgent', 
        'countArchived', 
        'countCompleted', 
        'services', 
        'employees', 
        'user',
        'unreadNotificationsCount'
    ));
}

    // Show courrier creation form
    public function create()
    {
        $user = Auth::guard('employee')->user();
        $notifications = Notification::where('user_id', $user->id)
            ->where('read_status', 'non lu')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        return view('secretary.create', compact('user', 'notifications'));
    }

    // Store a new courrier
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

    // Generate a unique reference for the courrier
    $reference = 'COURR-' . strtoupper(uniqid());

    // Get the authenticated employee (secretary)
    $user = Auth::guard('employee')->user();

    try {
        // Store the document if uploaded
        $filePath = $request->hasFile('document') ? $request->file('document')->store('documents', 'public') : null;

        // Create the courrier with the `created_by` field set to the authenticated employee's ID
        // In your CourrierController's store method, the following code should work now:

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
                'created_by' => $user->id, // Setting the created_by field
]);


        // Get the service ID, user IDs, and deadline if provided
        $serviceId = $validatedData['service_id'] ?? null;
        $userIds = $validatedData['user_ids'] ?? [];
        $deadline = $validatedData['deadline'] ?? null;

        // Retrieve the employees either by service or by the selected user IDs
        $employees = [];

        if (empty($userIds) && $serviceId) {
            // Get all employees from the selected service
            $employees = Employee::where('service_id', $serviceId)->get();
        } elseif (!empty($userIds)) {
            // Get the employees by the selected user IDs
            $employees = Employee::whereIn('id', $userIds)->get();
        }

        // Create notifications and send emails to the selected employees
        foreach ($employees as $employee) {
            Notification::create([
                'courrier_id' => $courrier->id,
                'service_id' => $serviceId,
                'user_id' => $employee->id,
                'commentaire' => 'Vous avez une nouvelle tâche.',
                'read_status' => 'non lu',
                'deadline' => $deadline,
            ]);

            // Send an email notification to the employee
            Mail::to($employee->email)->send(new CourrierNotificationMail($courrier, $employee));
        }

        // Redirect back with a success message
        return redirect()->route('secretary.index')->with('success', 'Courrier envoyé avec succès !');
    } catch (\Illuminate\Database\QueryException $e) {
        // Redirect back with a database error message
        return redirect()->back()->withErrors(['message' => 'Une erreur est survenue lors de l\'envoi du courrier.']);
    } catch (\Exception $e) {
        // Redirect back with a general error message
        return redirect()->back()->withErrors(['message' => 'Une erreur inattendue est survenue.']);
    }
}


    // Show form to distribute courrier
    public function distribute($id)
    {
        $courrier = Courrier::findOrFail($id);
        $services = Service::all();
        return view('secretary.courriers.distribute', compact('courrier', 'services'));
    }

    // Distribute courrier
    
    // Export courriers to PDF
    public function exportPdf()
    {
        $user = Auth::guard('employee')->user();
        $notifications = Notification::where('user_id', $user->id)
            ->where('read_status', 'non lu')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        $courriers = Courrier::all();
        $pdf = Pdf::loadView('secretary.export-pdf', compact('courriers', 'user', 'notifications'));
        return $pdf->download('courriers.pdf');
    }

    public function indexForSecretary()
{
    $userId = auth()->id(); // ID de l'utilisateur actuellement connecté
    $courriers = Notification::where('user_id', $userId)->get();

    return view('secretary.courriers', compact('courriers'));
}
public function upload(Request $request)

{   
    $user = Auth::guard('employee')->user();
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
        return view('secretary.create', [
            'extractedData' => $text,
            'user' => $user,
            'notifications' => $notifications,
        ]);    }

    return redirect()->route('secretary.upload.form')->withErrors(['document' => 'Le document est requis.']);
}

public function processUpload(Request $request)
{   
    $user = Auth::guard('employee')->user();
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

        return view('secretary.create', [
            'extractedData' => $extractedData,
            'user' => $user,
            'notifications' => $notifications
        ]);
    }

    return redirect()->route('secretary.upload.form')->withErrors(['document' => 'Le document est requis.']);
}
public function send(Request $request, $courrierId)
{
    $courrier = Courrier::findOrFail($courrierId);
    $user = Auth::guard('employee')->user();
    
    if (!$user) {
        return redirect()->back()->withErrors('Authenticated user not found.');
    }

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
        return redirect()->back()->withErrors('No users selected for notification.');
    }

    return redirect()->route('secretary.show', $courrierId)
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
        'content' => $request->content,
        'status' => $request->status,
        'sender' => $request->sender,
        'recipient' => $request->recipient,
        'created_at' => $request->created_at,
        'document' => $filePath,
    ]);
    
    return redirect()->route('secretary.index')->with('success', 'Courrier mis à jour avec succès!');
}
public function edit($id)
{   
    $user = auth()->user();
    
    $courrier = Courrier::findOrFail($id);
    $user = Auth::guard('employee')->user();
        $userId = Auth::id();
        $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();

    $courrier = Courrier::findOrFail($id);
    return view('secretary.update', compact('courrier', 'user', 'notifications'));
}
public function show($id)
{
    $courrier = Courrier::findOrFail($id);

    $user = Auth::guard('employee')->user();

    $notifications = Notification::where('user_id', $user->id)
        ->where('read_status', 'non lu') 
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();

    // Return the view with the courrier, user, and notifications data
    return view('secretary.show', compact('courrier', 'user', 'notifications'));
}


    public function destroy($id)
    {   

        $user = Auth::guard('employee')->user();

        $courrier = Courrier::findOrFail($id);
        Storage::disk('public')->delete($courrier->document);
        $courrier->delete();
        return redirect()->route('secretary.index')->with('success', 'Courrier supprimé avec succès.');
    }
    public function downloadPdf(Request $request)
{
    $user = Auth::guard('employee')->user();

    // Query notifications for the current user
    $notifications = Notification::with('courrier')
        ->where('user_id', $user->id)
        ->get();
    $courriersCreatedByEmployee = Courrier::where('created_by', $user->id)->get();
    // Generate PDF using the DomPDF package
    $pdf = PDF::loadView('secretary.myPDF', compact('notifications', 'courriersCreatedByEmployee'));

    // Return the generated PDF as a download
    return $pdf->download('courriers.pdf');
}
// SecretaryController.php

public function showNotification($id)
{
    $notification = Notification::where('id', $id)
        ->where('user_id', Auth::guard('employee')->id()) // Ensure notification belongs to the current user
        ->firstOrFail();
        
    $courrier = Courrier::findOrFail($notification->courrier_id);

    // Mark the notification as read
    $notification->update(['read_status' => 'lu']); // Adjust as needed

    // Redirect to the courrier details
    return redirect()->route('secretary.show', $courrier->id);
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
public function editProfile($id)
{
    $user = Auth::guard('employee')->user();
    $notifications = Notification::where('user_id', $user->id)
            ->where('read_status', 'non lu')
            ->get();
    return view('secretary.editprofile', compact('user', 'notifications'));
}

public function updateProfile(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone_number' => 'nullable|string|max:20',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = Auth::guard('employee')->user();
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->phone_number = $request->input('phone_number');

    if ($request->hasFile('image')) {
        // Delete the old image if it exists
        if ($user->image && Storage::exists('public/' . $user->image)) {
            Storage::delete('public/' . $user->image);
        }

        // Store the new image
        $path = $request->file('image')->store('images', 'public');
        $user->image = $path;
    }

    $user->save();

    return redirect()->route('secretary.edit-profile', $user->id)->with('success', 'Profile updated successfully');
}

public function editPassword($id)
{
    $user = Auth::guard('employee')->user();
    $notifications = Notification::where('user_id', $user->id)
            ->where('read_status', 'non lu')
            ->get();
    return view('secretary.editPassword', compact('user', 'notifications'));
}

public function updatePassword(Request $request, $id)
{
    $request->validate([
        'old_password' => 'required|string',
        'new_password' => 'required|string|min:8|confirmed',
    ]);

    $user = Auth::guard('employee')->user();

    if (!Hash::check($request->input('old_password'), $user->password)) {
        return redirect()->route('secretary.edit-password', $user->id)
            ->withErrors(['old_password' => 'The old password is incorrect.']);
    }

    $user->password = Hash::make($request->input('new_password'));
    $user->save();

    return redirect()->route('secretary.edit-password', $user->id)->with('success', 'Password updated successfully');
}

}
