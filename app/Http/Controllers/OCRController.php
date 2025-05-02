<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Courrier;
use thiagoalessio\TesseractOCR\TesseractOCR;

class OCRController extends Controller
{
    public function ocrImage(Request $request)
{
    $request->validate([
        'image' => 'required|image|mimes:jpeg,png,jpg|max:2048',
    ]);

    $image = $request->file('image');
    $imagePath = $image->storeAs('images', 'img-1.png', 'public');

    $ocrText = (new TesseractOCR(storage_path('app/public/images/img-1.png')))
        ->lang('eng') 
        ->run();

    return response()->json(['text' => $ocrText]);
}
}    