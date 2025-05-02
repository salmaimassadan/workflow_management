<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Response;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;
use Smalot\PdfParser\Parser;
use Barryvdh\DomPDF\Facade\Pdf;

class ResponseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
{
    $search = $request->get('search', '');

    $answers = Response::when($search, function ($query) use ($search) {
        return $query->where('content', 'like', '%' . $search . '%')
                     ->orWhereHas('courrier', function ($q) use ($search) { // Use the relationship name here
                         $q->where('reference', 'like', '%' . $search . '%')  // Adjust the field name you want to search
                           ->orWhere('created_by', 'like', '%' . $search . '%');
                     });
    })->paginate(10);

    $user = auth()->user();
    $userId = Auth::id();

    $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();

    return view('responses.index', compact('answers', 'user', 'notifications'));
}


    
    public function show(Response $answer)
    {   
        $user = auth()->user();
        $userId = Auth::id();

        $notifications = Notification::where('user_id', $userId)
        ->where('read_status', 0)
        ->orderBy('created_at', 'desc')
        ->limit(8)
        ->get();
        return view('responses.show', compact('answer', 'user', 'notifications'));
    }


    public function destroy(Response $answer)
    {
        $answer->delete();

        return redirect()->route('answers.index')
                         ->with('success', 'Response deleted successfully.');
    }

public function downloadPdf()
    {
        $answers = Response::all(); 

        $pdf = PDF::loadView('responses.myPDF', ['responses' => $answers]);

        return $pdf->download('responses_list.pdf');
    }
}
