<?php

namespace App\Http\Controllers;

use App\Models\User; 
use Illuminate\Support\Facades\Auth;


class LayoutController extends Controller
{
    /**
     * Show the main layout with a dynamic title and breadcrumb.
     *
     * @param  string  $title
     * @param  string  $breadcrumb
     * @return \Illuminate\View\View
     */
    public function index()
{
    $user = Auth::user(); // Or however you retrieve the user
    return view('layout', ['user' => $user]);
}
}