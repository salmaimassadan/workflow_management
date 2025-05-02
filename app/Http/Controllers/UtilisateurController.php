<?php

namespace App\Http\Controllers;
use App\Services\OpenAIService;
use Illuminate\Http\Request;
use App\Models\Courrier;
use App\Models\Dossier;

use App\Models\Notification;
use App\Models\Service;
use App\Models\Employee;
use Illuminate\Support\Facades\Hash;
use App\Models\CourrierTemplate;
use OpenAI;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;
use App\Mail\CourrierNotificationMail;
use Smalot\PdfParser\Parser;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Illuminate\Support\Facades\Storage;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Models\Response;
use App\Services\ResponseGeneratorService;


class UtilisateurController extends Controller
{   

    public function dashboard(Request $request)
{
    $user = Auth::guard('employee')->user();

    if (!$user) {
        return redirect()->route('login')->with('error', 'Please log in to access the dashboard.');
    }

    // Validate incoming filters
    $validated = $request->validate([
        'search' => 'nullable|string',
        'status' => 'nullable|string|in:urgent,traité,non lu,lu,archivé',
        'date' => 'nullable|date',
    ]);

    $courrierQuery = Notification::with('courrier')
        ->where('user_id', $user->id)
        ->orderBy('created_at', 'desc')
        ->whereHas('courrier', function($q) use ($request) {
            if ($request->has('status') && $request->status) {
                $q->where('status', $request->status);
            }
        
        });

    if ($request->has('search') && $request->search) {
        $courrierQuery->whereHas('courrier', function($q) use ($request) {
            $q->where('reference', 'like', '%' . $request->search . '%');
        });
    }

    if ($request->has('date') && $request->date) {
        $courrierQuery->whereDate('created_at', $request->date);
    }

    // Fetch paginated courriers
    $notifications = $courrierQuery->paginate(5);

    return view('utilisateur.dashboard', [
        'user' => $user,
        'notifications' => $notifications,
    ]);
}

public function index(Request $request)
{
    $user = Auth::guard('employee')->user(); // Get the authenticated employee
    
    // Initialize the notification query for the current user
    $notificationQuery = Notification::with('courrier')
        ->where('user_id', $user->id); // Only get notifications for the current user

    // Apply search filter if provided
    if ($request->filled('search')) {
        $search = $request->input('search');
        $notificationQuery->whereHas('courrier', function($q) use ($search) {
            $q->where(function($q) use ($search) {
                $q->where('reference', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%")
                  ->orWhere('subject', 'like', "%{$search}%")
                  ->orWhere('type', 'like', "%{$search}%")
                  ->orWhere('sender', 'like', "%{$search}%")
                  ->orWhere('recipient', 'like', "%{$search}%");
            });
        });
    }

    // Apply status filter if provided
    if ($request->filled('status')) {
        $status = $request->input('status');
        $notificationQuery->whereHas('courrier', function($q) use ($status) {
            $q->where('status', $status);
        });
    }

    // Paginate notifications
    $notifications = $notificationQuery->paginate(10);

    // Fetch courriers created by the employee
    $courriersCreatedByEmployee = Courrier::where('created_by', $user->id)->get();

    // Count courriers based on different statuses
    $countRead = $notificationQuery->clone()->whereHas('courrier', function($q) {
        $q->where('status', 'lu');
    })->count();

    $countUnread = $notificationQuery->clone()->whereHas('courrier', function($q) {
        $q->where('status', 'non lu');
    })->count();

    $countUrgent = $notificationQuery->clone()->whereHas('courrier', function($q) {
        $q->where('status', 'urgent');
    })->count();

    $countArchived = $notificationQuery->clone()->whereHas('courrier', function($q) {
        $q->where('status', 'archivé');
    })->count();

    $countCompleted = $notificationQuery->clone()->whereHas('courrier', function($q) {
        $q->where('status', 'traité');
    })->count();

    // Fetch all services and employees
    $services = Service::all();
    $employees = Employee::all();

    return view('utilisateur.courriers', compact(
        'notifications', 
        'courriersCreatedByEmployee', 
        'countRead', 
        'countUnread', 
        'countUrgent', 
        'countArchived', 
        'countCompleted', 
        'services', 
        'employees', 
        'user'
    ));
}


    public function editProfile($id)
{
    $user = Auth::guard('employee')->user();
    $notifications = Notification::where('user_id', $user->id)
            ->where('read_status', 'non lu')
            ->get();
    return view('utilisateur.editprofile', compact('user', 'notifications'));
}

public function updateProfile(Request $request, $id)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|max:255',
        'phone' => 'nullable|string|max:20',
        'image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
    ]);

    $user = Auth::guard('employee')->user();
    $user->name = $request->input('name');
    $user->email = $request->input('email');
    $user->phone = $request->input('phone');

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

    return redirect()->route('utilisateur.edit-profile', $user->id)->with('success', 'Profile updated successfully');
}

public function editPassword($id)
{
    $user = Auth::guard('employee')->user();
    $notifications = Notification::where('user_id', $user->id)
            ->where('read_status', 'non lu')
            ->get();
    return view('utilisateur.editPassword', compact('user', 'notifications'));
}

public function updatePassword(Request $request, $id)
{
    $request->validate([
        'old_password' => 'required|string',
        'new_password' => 'required|string|min:8|confirmed',
    ]);

    $user = Auth::guard('employee')->user();

    if (!Hash::check($request->input('old_password'), $user->password)) {
        return redirect()->route('utilisateur.edit-password', $user->id)
            ->withErrors(['old_password' => 'The old password is incorrect.']);
    }

    $user->password = Hash::make($request->input('new_password'));
    $user->save();

    return redirect()->route('utilisateur.edit-password', $user->id)->with('success', 'Password updated successfully');
}

public function showNotification($id)
{
    $notification = Notification::where('id', $id)
        ->where('user_id', Auth::guard('employee')->id()) // Ensure notification belongs to the current user
        ->firstOrFail();
        
    $courrier = Courrier::findOrFail($notification->courrier_id);

    // Mark the notification as read
    $notification->update(['read_status' => 'lu']); // Adjust as needed

    // Redirect to the courrier details
    return redirect()->route('utilisateur.show', $courrier->id);
}

public function notifgetNotifications()
    {
        // Fetch notifications for the authenticated employee
        $user = Auth::guard('employee')->user();
        $notifications = Notification::where('user_id', $user->id)
                        ->where('read_status', 'non lu')
                        ->orderBy('created_at', 'desc')
                        ->limit(8)
                        ->get();
                        

        return view('utilisateur.dashboard', compact('notifications'));
    }

    public function notifmarkAsRead($id)
    {
        // Fetch the notification for the authenticated employee
        $user = Auth::guard('employee')->user();
        $notification = Notification::where('id', $id)->where('user_id', $user->id)->first();

        if($notification) {
            $notification->update(['read_status' => 'lu']);
        }

        // Redirect to the detail page of the related courrier or back
        return redirect()->route('utilisateur.show', $notification->courrier_id);
    }

    public function notifsomeMethod()
    {
        $notifications = Notification::where('user_id', auth()->id())->get();
        return view('utilisateur.layout', compact('notifications'));
    }

    public function notifindex()
    {
        $notifications = Notification::where('created_by', auth()->id())->get();; // Récupère toutes les notifications
        $user = Auth::guard('employee')->user();
        
        return view('utilisateur.notifisindex', compact('notifications', 'user'));
    }

    // Affiche une notification spécifique
    public function notifshow($id)
{   
    // Récupère l'utilisateur authentifié avec la garde 'employee'
    $user = Auth::guard('employee')->user();

    // Si l'utilisateur n'est pas connecté, redirige vers la page de connexion
    if (!$user) {
        return redirect()->route('login');
    }

    // Récupère la notification par ID et les notifications liées à cet utilisateur
    $notification = Notification::findOrFail($id);
    $notifications = Notification::where('user_id', $user->id)->get();

    // Affiche la vue avec les données compactées
    return view('utilisateur.notifisshow', compact('notification', 'user', 'notifications'));
}


    // Affiche le formulaire d'édition pour une notification
    public function notifedit($id)
    {   
        $user = Auth::guard('employee')->user();
        $notifications = Notification::where('user_id', auth()->id())->get();

        $notification = Notification::findOrFail($id); // Trouve la notification par ID
        return view('utilisateur.notifisedit', compact('notification', 'user', 'notifications'));
    }

    // Met à jour une notification
    public function notifupdate(Request $request, $id)
    {
        $notification = Notification::findOrFail($id); // Trouve la notification par ID
        
        // Valide les données du formulaire
        $validatedData = $request->validate([
            'commentaire' => 'required|string|max:255',
            'read_status' => 'required|boolean',
            'deadline' => 'nullable|date',
        ]);

        // Met à jour les champs modifiables
        $notification->update($validatedData);

        return redirect()->route('utilisateur.notifisindex')->with('success', 'Notification mise à jour avec succès.');
    }

    // Supprime une notification
    public function notifdestroy($id)
    {
        $notification = Notification::findOrFail($id); // Trouve la notification par ID
        $notification->delete(); // Supprime la notification

        return redirect()->route('utilisateur.notifisindex')->with('success', 'Notification supprimée avec succès.');
    }

public function send(Request $request, $courrierId)
{
    $courrier = Courrier::findOrFail($courrierId);
    $user = Auth::guard('employee')->user();

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
        // Skip the notification creation if no user_ids are provided
        // or handle it differently, depending on your needs.
        return redirect()->back()->withErrors('No users selected for notification.');
    }

    return redirect()->route('utilisateur.courriers', $courrierId)
                     ->with('success', 'Courrier envoyé avec succès!');
}
public function show($id)
{
    $courrier = Courrier::findOrFail($id);

    // Get the authenticated employee
    $user = Auth::guard('employee')->user();
    $templates = Response::all();
    // Get unread notifications for the authenticated user
    $notifications = Notification::where('user_id', $user->id)
        ->where('read_status', 0) // Assuming 0 means unread
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();

    // Return the view with the courrier, user, and notifications data
    return view('utilisateur.show', compact('courrier', 'user', 'notifications', 'templates'));
}
public function downloadPdf(Request $request)
{
    $user = Auth::guard('employee')->user();

    // Query notifications for the current user
    $notifications = Notification::with('courrier')
        ->where('user_id', $user->id)
        ->get();
    // Generate PDF using the DomPDF package
    $pdf = PDF::loadView('utilisateur.myPDF', compact('notifications'));

    // Return the generated PDF as a download
    return $pdf->download('courriers.pdf');
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




protected $responseGenerator;

    public function __construct(ResponseGeneratorService $responseGenerator)
    {
        $this->responseGenerator = $responseGenerator;
    }

    public function handleCourrier(Request $request, $courrierId)
{
    // Récupérer le courrier
    $courrier = Courrier::find($courrierId);

    // Assurer que le courrier existe
    if (!$courrier) {
        return redirect()->back()->with('error', 'Courrier non trouvé.');
    }

    // Récupérer l'utilisateur authentifié via le guard `employee`
    $user = Auth::guard('employee')->user();
    $notifications = Notification::with('courrier')
        ->where('user_id', $user->id)
        ->get();
    // Générer le contenu de la réponse en utilisant le service de génération de réponses
    $generatedContent = $this->responseGenerator->generateResponse($courrier);

    // Afficher la vue avec la réponse générée
    return view('utilisateur.responsesedit', [
        'courrier' => $courrier,
        'generatedContent' => $generatedContent,
        'user' =>$user,
        'notifications' =>$notifications,
    ]);
}
public function showResponseForm($courrierId)
{
    // Récupérer le courrier
    $courrier = Courrier::find($courrierId);

    // Assurer que le courrier existe
    if (!$courrier) {
        return redirect()->back()->with('error', 'Courrier non trouvé.');
    }

    // Générer la réponse automatiquement
    $generatedContent = $this->generateResponse($courrier);

    // Afficher la vue avec la réponse générée
    return view('utilisateur.responsesedit', [
        'courrier' => $courrier,
        'generatedContent' => $generatedContent,
    ]);
}
public function saveResponse(Request $request, $courrierId)
{
    // Valider les données du formulaire
    $request->validate([
        'content' => 'required|string',
    ]);

    // Récupérer le courrier
    $courrier = Courrier::find($courrierId);

    // Assurer que le courrier existe
    if (!$courrier) {
        return redirect()->back()->with('error', 'Courrier non trouvé.');
    }

    // Sauvegarder la réponse dans la base de données
    Response::create([
        'courrier_id' => $courrier->id,
        'content' => $request->input('content'),
        'created_by' => Auth::guard('employee')->user()->id, // ou `Auth::id()` si vous utilisez le guard par défaut
    ]);

    // Rediriger ou retourner une réponse HTTP
    return redirect()->route('utilisateur.show', $courrierId)->with('success', 'Réponse enregistrée avec succès.');
}



public function Dossierindex(Request $request)
{
    $user = Auth::guard('employee')->user();
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

    // Récupérer les courriers associés aux notifications pour cet utilisateur
    $courriers = Notification::with('courrier')
        ->where('user_id', $userId)
        ->get()
        ->pluck('courrier');

    $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();

    return view('utilisateur.dossiersindex', compact('dossiers', 'user', 'notifications', 'courriers'));
}

public function Dossiershow(Dossier $dossier)
{   
    $user = Auth::guard('employee')->user();
    $userId = Auth::id();

    // Ensure the dossier was created by the authenticated user
    if ($dossier->created_by !== $userId) {
        abort(403, 'Unauthorized action.');
    }

    $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();
    
    $dossier->load('courriers'); 
    return view('utilisateur.dossiersshow', compact('dossier', 'user', 'notifications'));
}


public function Dossiercreate()
{   
    $user = Auth::guard('employee')->user();
    $userId = Auth::id();

    $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();

    $courriers = Notification::with('courrier')
        ->where('user_id', $userId)
        ->get()
        ->pluck('courrier');

    return view('utilisateur.dossierscreate', compact('courriers', 'user', 'notifications'));
}

public function Dossierstore(Request $request)
{
    $reference = 'DOSS-' . strtoupper(uniqid());

    $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'courrier_refs' => 'nullable|array',
        'courrier_refs.*' => 'exists:courriers,reference',
    ]);

    $createdBy = Auth::guard('employee')->id();

    $dossier = Dossier::create([
        'reference' => $reference,
        'title' => $request->title,
        'description' => $request->description,
        'created_by' => $createdBy,
    ]);

    // Handle selected courriers
    if ($request->has('courrier_refs')) {
        $references = $request->courrier_refs;

        // Find courriers by reference and attach to the dossier
        $courriers = Courrier::whereIn('reference', $references)->get();
        $dossier->courriers()->attach($courriers);
    }

    return redirect()->route('utilisateur.dossiersindex')->with('success', 'Dossier created successfully.');
}


public function Dossieredit(Dossier $dossier)
{   
    $user = Auth::guard('employee')->user();
    $userId = Auth::id();
    if ($dossier->created_by !== $userId) {
        abort(403, 'Unauthorized action.');
    }
    $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();

    $courriers = Notification::with('courrier')
        ->where('user_id', $userId)
        ->get()
        ->pluck('courrier');

    // Convert the courrier_refs to an array if it's a string or null
    $dossier->courrier_refs = explode(', ', $dossier->courrier_refs ?? '');

    return view('utilisateur.dossiersedit', compact('dossier', 'courriers', 'user', 'notifications'));
}

public function Dossierupdate(Request $request, Dossier $dossier)
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

    return redirect()->route('utilisateur.dossiersindex')->with('success', 'Dossier updated successfully.');
}

public function Dossierdestroy(Dossier $dossier)
{   
    $user = Auth::guard('employee')->user();
    $userId = Auth::id();
    if ($dossier->created_by !== $userId) {
        abort(403, 'Unauthorized action.');
    }
    $dossier->delete();
    return redirect()->route('utilisateur.dossiersindex')->with('success', 'Dossier deleted successfully.');
}

public function generatePDF()
{
    $user = Auth::guard('employee')->user();
    $dossiers = Dossier::all();
    $pdf = PDF::loadView('utilisateur.dossiersmyPDF', ['dossiers' => $dossiers]);
    return $pdf->download('dossiers.pdf');
}


}
