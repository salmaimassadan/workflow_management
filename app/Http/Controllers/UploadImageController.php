<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use thiagoalessio\TesseractOCR\TesseractOCR;
use Smalot\PdfParser\Parser;
use Illuminate\Http\Response;

class UploadImageController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate(["document" => "required|mimes:png,jpg,jpeg,pdf|max:10000"]);
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

        // Here you can save the extracted text to the database or further process it
        return view('results', ['extractedData' => $text]);
    }
}
