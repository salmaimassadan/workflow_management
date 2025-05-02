<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use App\Models\Employee;


class NotificationController extends Controller
{
    public function getNotifications()
    {
        // Fetch notifications for the authenticated employee
        $user = Auth::guard('employee')->user();
        $notifications = Notification::where('user_id', $user->id)
                        ->where('read_status', 'non lu')
                        ->orderBy('created_at', 'desc')
                        ->limit(8)
                        ->get();
                        

        return view('dashboard', compact('notifications'));
    }

    public function markAsRead($id)
    {
        // Fetch the notification for the authenticated employee
        $user = Auth::guard('employee')->user();
        $notification = Notification::where('id', $id)->where('user_id', $user->id)->first();

        if($notification) {
            $notification->update(['read_status' => 'lu']);
        }

        // Redirect to the detail page of the related courrier or back
        return redirect()->route('secretary.show', $notification->courrier_id);
    }

    public function someMethod()
    {
        $notifications = Notification::where('user_id', auth()->id())->get();
        return view('secretary.layout', compact('notifications'));
    }

    public function index()
    {
        $notifications = Notification::where('created_by', auth()->id())->get(); // Récupère toutes les notifications
        $user = Auth::guard('employee')->user();
        
        return view('notifis.index', compact('notifications', 'user'));
    }

    // Affiche une notification spécifique
    public function show($id)
{   
    // Récupère l'utilisateur authentifié avec la garde 'employee'
    $user = Auth::guard('employee')->user();

    // Si l'utilisateur n'est pas connecté, redirige vers la page de connexion
    if (!$user) {
        return redirect()->route('login');
    }

    // Vérifie si la notification existe
    $notification = Notification::find($id);
    if (!$notification) {
        return redirect()->route('notifications.index')->withErrors('Notification not found.');
    }

    // Récupère les notifications liées à cet utilisateur
    $notifications = Notification::where('created_by', $user->id)->get();

    // Affiche la vue avec les données compactées
    return view('notifis.show', compact('notification', 'user', 'notifications'));
}


    // Affiche le formulaire d'édition pour une notification
    public function edit($id)
    {   
        $user = Auth::guard('employee')->user();
        $notifications = Notification::where('created_by', auth()->id())->get();

        $notification = Notification::findOrFail($id); // Trouve la notification par ID
        return view('notifis.edit', compact('notification', 'user', 'notifications'));
    }

    // Met à jour une notification
    public function update(Request $request, $id)
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

        return redirect()->route('notifis.index')->with('success', 'Notification mise à jour avec succès.');
    }

    // Supprime une notification
    public function destroy($id)
    {
        $notification = Notification::findOrFail($id); // Trouve la notification par ID
        $notification->delete(); // Supprime la notification

        return redirect()->route('notifis.index')->with('success', 'Notification supprimée avec succès.');
    }
}
