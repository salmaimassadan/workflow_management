<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\DashController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\OCRController;
use App\Http\Controllers\CourrierController;
use App\Http\Controllers\SecretaryController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\DossierController;
use App\Http\Controllers\UtilisateurController;
use App\Http\Controllers\DistributionController;
use App\Http\Controllers\ResponseController;






/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});


//login & logout
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
// Show the form to edit profile
Route::get('/users/{user}/edit-profile', [AuthController::class, 'editProfile'])->name('users.edit-profile');

// Update the user profile
Route::put('/users/{user}/update-profile', [AuthController::class, 'updateProfile'])->name('users.update-profile');

// Show the form to edit password
Route::get('/users/{user}/edit-password', [AuthController::class, 'editPassword'])->name('users.edit-password');

// Update the user password
Route::put('/users/{user}/update-password', [AuthController::class, 'updatePassword'])->name('users.update-password');

Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

//dashboard
Route::get('/dashboard', [DashController::class, 'index'])->name('dashboard');

//gestion des services
Route::get('services', [ServiceController::class, 'index'])->name('services');
Route::resource('/services', ServiceController::class);
Route::get('download-pdf', [ServiceController::class, 'downloadPdf'])->name('pdf.download');
Route::get('download-pdf/{id}', [ServiceController::class, 'downloadPdf_view'])->name('pdf.download.view');
Route::get('/services/{id}/users', [ServiceController::class, 'getUsers']);
Route::get('/services/{serviceId}/employees', [CourrierController::class, 'employeesByService'])->name('services.employees');

//gestion des employees
Route::get('employees', [UserController::class, 'index'])->name('employees');
Route::resource('/employees', UserController::class);
Route::get('/employees/pdf', [UserController::class, 'downloadPdf'])->name('employees.pdf');
Route::get('/employee/{id}/pdf', [UserController::class, 'downloadPdf_view'])->name('pdf.employee.details');

//gestion des courriers

// Resource routes for Courrier
Route::resource('courriers', CourrierController::class);


Route::post('/courriers/process-image', [CourrierController::class, 'processImage'])->name('courriers.process-image');




Route::get('/upload', function() {
    return view('courriers.create'); // This should point to the correct view
})->name('upload.form');

Route::post('/upload', [CourrierController::class, 'upload'])->name('upload.process');

Route::resource('courriers', CourrierController::class);



Route::post('/upload', [CourrierController::class, 'upload'])->name('upload.process');
Route::get('courriers/create', [CourrierController::class, 'create'])->name('courriers.create');
Route::post('courriers/store', [CourrierController::class, 'store'])->name('courriers.store');


Route::get('mypdf', [CourrierController::class, 'generatePdf'])->name('courriers.pdf');


Route::post('/courriers/{id}/send-email', [CourrierController::class, 'send'])->name('courriers.send');



//notification

Route::post('/notifications/read/{id}', [NotificationController::class, 'markAsRead'])->name('notifications.read');
Route::get('/notifications', [NotificationController::class, 'getNotifications'])->name('notifications.index');
Route::get('/layout', [NotificationController::class, 'someMethod'])->name('layout');



//dossier
Route::resource('dossiers', DossierController::class);
Route::get('tech-pdf', [DossierController::class, 'generatePDF'])->name('dossiers.pdf');



//roles
// Route::get('/responsable/dashboard', [ResponsableController::class, 'index'])->name('responsable.dashboard');
// Route::get('/auditor/dashboard', [AuditorController::class, 'index'])->name('auditor.dashboard');
// Route::get('/operator/dashboard', [OperatorController::class, 'index'])->name('operator.dashboard');


Route::group(['middleware' => ['auth:employee']], function () {
    Route::get('/utilisateur/dashboard', [UtilisateurController::class, 'dashboard'])->name('utilisateur.dashboard');
});
Route::group(['middleware' => ['auth:employee']], function () {
    Route::get('/secretary/dashboard', [SecretaryController::class, 'dashboard'])->name('secretary.dashboard');
});



//secretary

// Tableau de bord du secrétaire
Route::get('/secretary/dashboard', [SecretaryController::class, 'dashboard'])->name('secretary.dashboard');

// routes/web.php
Route::get('/secretary/Mycourriers', [CourrierController::class, 'indexForSecretary'])->name('secretaire.courriers.index');

// Liste des courriers crées
Route::get('/Mycourriers', [SecretaryController::class, 'index'])->name('secretary.index');
// Liste des courriers reçus
Route::get('/MyReceivedcourriers', [SecretaryController::class, 'index_2'])->name('secretary.index_2');

// Création d'un nouveau courrier
Route::get('/Mycourriers/create', [SecretaryController::class, 'create'])->name('secretary.create');
Route::post('/Mycourriers', [SecretaryController::class, 'store'])->name('secretary.store');

// Distribution de courrier
Route::get('/Mycourriers/{id}/distribute', [SecretaryController::class, 'distribute'])->name('secretary.distribute');
Route::post('/Mycourriers/{id}/send', [SecretaryController::class, 'send'])->name('secretary.send');

// Liste des distributions effectuées
Route::get('/distributions', [SecretaryController::class, 'distributions'])->name('distributions.index');


Route::get('/secretary/upload', function() {
    return view('secretary.create'); // This should point to the correct view
})->name('secretary.upload.form');

Route::post('/secretary/upload', [SecretaryController::class, 'upload'])->name('secretary.upload.process');

Route::get('/secretary/create', [SecretaryController::class, 'create'])->name('secretary.create');
Route::post('/secretary/store', [SecretaryController::class, 'store'])->name('secretary.store');


Route::get('/secretary/download-pdf', [SecretaryController::class, 'downloadPdf'])->name('secretary.downloadPdf');
Route::get('secretary/viewcourriers/{id}', [SecretaryController::class, 'show'])->name('secretary.show');
Route::get('/secretary/editcourriers/{id}', [SecretaryController::class, 'edit'])->name('secretary.edit');
Route::put('/secretary/editcourriers/{id}', [SecretaryController::class, 'update'])->name('secretary.update');
Route::post('/secretary/courriers/{id}/send', [SecretaryController::class, 'send'])->name('secretary.send');

// Custom route for deleting a courrier
Route::delete('secretary/courriers/{id}', [SecretaryController::class, 'destroy'])->name('secretary.destroy');
Route::get('notifs/{id}', [SecretaryController::class, 'showNotification'])->name('secretary.showNotification');










Route::get('/secretary/edit-profile/{id}', [SecretaryController::class, 'editProfile'])->name('secretary.edit-profile');
Route::put('/secretary/update-profile/{id}', [SecretaryController::class, 'updateProfile'])->name('secretary.update-profile');
Route::get('/secretary/edit-password/{id}', [SecretaryController::class, 'editPassword'])->name('secretary.edit-password');
Route::put('/secretary/update-password/{id}', [SecretaryController::class, 'updatePassword'])->name('secretary.update-password');




//gestion des notifs

Route::get('/notifis', [NotificationController::class, 'index'])->name('notifis.index');  // Liste des notifications
Route::get('/notifis/{id}', [NotificationController::class, 'show'])->name('notifis.show'); // Afficher une notification spécifique
Route::get('/notifis/{id}/edit', [NotificationController::class, 'edit'])->name('notifis.edit'); // Formulaire d'édition
Route::put('/notifis/{id}', [NotificationController::class, 'update'])->name('notifis.update'); // Mise à jour d'une notification
Route::delete('/notifis/{id}', [NotificationController::class, 'destroy'])->name('notifis.destroy'); // Suppression d'une notification



//utilisateur
Route::get('/utilisateur/dashboard', [UtilisateurController::class, 'dashboard'])->name('utilisateur.dashboard');
Route::get('/utilisateur/courriers', [UtilisateurController::class, 'index'])->name('utilisateur.index');

Route::get('/utilisateur/edit-profile/{id}', [UtilisateurController::class, 'editProfile'])->name('utilisateur.edit-profile');
Route::put('/utilisateur/update-profile/{id}', [UtilisateurController::class, 'updateProfile'])->name('utilisateur.update-profile');
Route::get('/utilisateur/edit-password/{id}', [UtilisateurController::class, 'editPassword'])->name('utilisateur.edit-password');
Route::put('/utilisateur/update-password/{id}', [UtilisateurController::class, 'updatePassword'])->name('utilisateur.update-password');


Route::get('/notifications/{id}', [UtilisateurController::class, 'showNotification'])->name('utilisateur.showNotification');
Route::post('/notifications/{id}/mark-as-read', [UtilisateurController::class, 'markAsRead'])->name('utilisateur.markAsRead');
Route::post('/utilisateur/courriers/{id}/send', [UtilisateurController::class, 'send'])->name('utilisateur.send');

Route::get('/utilisateur/download-pdf', [UtilisateurController::class, 'downloadPdf'])->name('utilisateur.downloadPdf');
Route::get('/utilisateur/viewcourriers/{id}', [UtilisateurController::class, 'show'])->name('utilisateur.show');
// routes/web.php

Route::get('/courriers/{id}/reply', [UtilisateurController::class, 'reply'])->name('courriers.reply');

// Route to generate a response based on the selected template
Route::post('/courriers/{id}/generate-response', [UtilisateurController::class, 'generateResponse'])->name('courriers.generateResponse');

// Route to store the generated response
Route::post('/responses', [UtilisateurController::class, 'storeResponse'])->name('responses.store');
Route::get('/responses', [UtilisateurController::class, 'storeResponse'])->name('responses.store');
// Route pour afficher le formulaire de réponse








Route::post('/utilisateur/{courrier}/handle', [UtilisateurController::class, 'handleCourrier'])->name('courriers.handle');
// Afficher le formulaire de réponse
Route::get('/courrier/{courrierId}/response', [UtilisateurController::class, 'showResponseForm'])
    ->name('responses.edit')
    ->middleware('auth:employee'); // Vérifiez ici si un middleware est appliqué

// Enregistrer la réponse
Route::post('/courrier/{courrierId}/response', [UtilisateurController::class, 'saveResponse'])
    ->name('responses.save')
    ->middleware('auth:employee'); // Vérifiez ici si un middleware est appliqué
    Route::get('/utilisateur/{serviceId}/employees', [UtilisateurController::class, 'employeesByService'])->name('services.employees');


    Route::middleware('auth:employee')->group(function () {
    
        // Route to display all notifications
        Route::get('/notifications', [UtilisateurController::class, 'notifindex'])
            ->name('utilisateur.notifisindex');
        
        // Route to display a specific notification
        Route::get('/notifications/{id}', [UtilisateurController::class, 'notifshow'])
            ->name('utilisateur.notifisshow');
        
        // Route to edit a notification
        Route::get('/notifications/{id}/edit', [UtilisateurController::class, 'notifedit'])
            ->name('utilisateur.notifisedit');
        
        // Route to update a notification
        Route::put('/notifications/{id}', [UtilisateurController::class, 'notifupdate'])
            ->name('utilisateur.notifisupdate');
        
        // Route to delete a notification
        Route::delete('/notifications/{id}', [UtilisateurController::class, 'notifdestroy'])
            ->name('utilisateur.notifisdestroy');
    
        // Route to fetch recent unread notifications for the dashboard
        Route::get('/get-notifications', [UtilisateurController::class, 'notifgetNotifications'])
            ->name('utilisateur.getNotifications');
        
        // Route to mark a notification as read
        Route::get('/mark-as-read/{id}', [UtilisateurController::class, 'notifmarkAsRead'])
            ->name('utilisateur.markAsRead');
        
        // Route to show a notification and redirect to related courrier
        Route::get('/notification/{id}/show', [UtilisateurController::class, 'showNotification'])
        ->name('utilisateur.showNotification');
    });


    Route::middleware(['auth:employee'])->group(function () {
        Route::get('/utilisateur/dossiers', [UtilisateurController::class, 'Dossierindex'])->name('utilisateur.dossiersindex');
        Route::get('/utilisateur/dossiers/create', [UtilisateurController::class, 'Dossiercreate'])->name('utilisateur.dossierscreate');
        Route::post('/utilisateur/dossiers', [UtilisateurController::class, 'Dossierstore'])->name('utilisateur.dossiersstore');
        Route::get('/utilisateur/dossiers/{dossier}', [UtilisateurController::class, 'Dossiershow'])->name('utilisateur.dossiersshow');
        Route::get('/utilisateur/dossiers/{dossier}/edit', [UtilisateurController::class, 'Dossieredit'])->name('utilisateur.dossiersedit');
        Route::put('/utilisateur/dossiers/{dossier}', [UtilisateurController::class, 'Dossierupdate'])->name('utilisateur.dossiersupdate');
        Route::delete('/utilisateur/dossiers/{dossier}', [UtilisateurController::class, 'Dossierdestroy'])->name('utilisateur.dossiersdestroy');
        Route::get('/utilisateur/dossiers/pdf', [UtilisateurController::class, 'generatePDF'])->name('utilisateur.dossierspdf');
    });




//distributions

Route::get('/distributions', [DistributionController::class, 'index'])->name('distributions.index');
Route::resource('/distributions', DistributionController::class);
Route::get('/distributions/download-pdf', [DistributionController::class, 'downloadPdf'])->name('distributions.download');

//responses

Route::get('/answers', [ResponseController::class, 'index'])->name('answers.index');
Route::resource('/answers', ResponseController::class);
// Route to download the PDF
Route::get('/answers/download-pdf', [ResponseController::class, 'downloadPdf'])->name('answers.download');
