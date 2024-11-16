<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Http;
use App\Models\File;

class FileController extends Controller
{
    public function index()
    {
        return view('upload');
    }

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:51200',  // PDF files up to 50 MB
            'title' => 'required|string|max:255',           // Title validation
        ]);

        try {
            // Handle file upload and saving file path
            if ($request->file('file')) {
                $filePath = $request->file('file')->store('uploads', 'public');
                $file = $request->file('file');
                $fileContent = file_get_contents($file->getRealPath());

                // Send the file to the Python API for text extraction
                $extractResponse = Http::timeout(180)->attach('file', $fileContent, $file->getClientOriginalName())
                        ->post('http://localhost:5000/extract_text_from_pdf');

                if (!$extractResponse->successful()) {
                    throw new \Exception('Failed to extract text from PDF');
                }
                $content = $extractResponse->json()['extracted_text'];

                // Send extracted text for encoding
                $encodeResponse = Http::post('http://localhost:5000/encode', ['text' => $content]);

                if (!$encodeResponse->successful()) {
                    throw new \Exception('Failed to encode text');
                }
                $encodedContent = $encodeResponse->json();

                // Send extracted text for category prediction
                $categoryResponse = Http::post('http://localhost:5000/predict_category', ['text' => $content]);

                if (!$categoryResponse->successful()) {
                    throw new \Exception('Failed to predict category');
                }
                $category = $categoryResponse->json()['category'];

                // Store file details in the database
                File::create([
                    'file_name' => $request->input('title'),
                    'title' => $request->input('title'),
                    'file_path' => $filePath,
                    'content' => $content,
                    'encoded_content' => json_encode($encodedContent),
                    'category' => $category,
                ]);

                if ($request->ajax()) {
                    return response()->json([
                        'status' => 200,
                        'success' => true,
                        'data' => [
                            'filePath' => $filePath,
                            'message' => 'File uploaded successfully'
                        ]
                    ], 200);
                } else {
                    return redirect()->back()->with([
                        'status' => 200,
                        'success' => true,
                        'filePath' => $filePath,
                        'message' => 'File uploaded successfully'
                    ]);
                }
            }

            throw new \Exception('No file uploaded');
        } catch (\Exception $e) {
            // Return error response for AJAX requests
            if ($request->ajax()) {
                return response()->json([
                    'status' => 500,
                    'success' => false,
                    'data' => [
                        'message' => $e->getMessage()
                    ]
                ], 500);
            } else {
                // Redirect back with error message for non-AJAX requests
                return redirect()->back()->withErrors(['error' => $e->getMessage()]);
            }
        }
    }

    // public function store(Request $request)
    // {
    //     // Validate the request
    //     $request->validate([
    //         'file' => 'required|file|mimes:pdf|max:51200',  // PDF files up to 50 MB
    //         'title' => 'required|string|max:255',           // Title validation
    //     ]);

    //     // Handle file upload and saving file path
    //     if ($request->file('file')) {
    //         $filePath = $request->file('file')->store('uploads', 'public'); // Stores file in storage/app/public/uploads
    //         $file = $request->file('file');
    //         $fileContent = file_get_contents($file->getRealPath());

    //         // // Placeholder values for `content`, `encoded_content`, and `category` fields
    //         // $content = "Placeholder content"; // Replace with content from the Python API
    //         // $encodedContent = "Placeholder encoded content"; // Replace with encoded content from Python API
    //         // $category = "Placeholder category"; // Replace with category from Python API

    //         // Send the file to the Python API for text extraction
    //         $extractResponse = Http::timeout(180)->attach('file', $fileContent, $file->getClientOriginalName())
    //                  ->post('http://localhost:5000/extract_text_from_pdf');

    //         if ($extractResponse->successful()) {
    //             $content = $extractResponse->json()['extracted_text'];
    //         } else {
    //             return response()->json(['error' => 'Failed to extract text from PDF'], 500);
    //         }

    //         // Send extracted text for encoding
    //         $encodeResponse = Http::post('http://localhost:5000/encode', [
    //             'text' => $content,
    //         ]);

    //         if ($encodeResponse->successful()) {
    //             $encodedContent = $encodeResponse->json();
    //         } else {
    //             return response()->json(['error' => 'Failed to encode text'], 500);
    //         }

    //         // Send extracted text for category prediction
    //         $categoryResponse = Http::post('http://localhost:5000/predict_category', [
    //             'text' => $content,
    //         ]);

    //         // Call Flask API to predict category
    //         $categoryResponse = Http::post('http://localhost:5000/predict_category', [
    //             'text' => $content,
    //         ]);

    //         if ($categoryResponse->successful()) {
    //             $category = $categoryResponse->json()['category'];
    //         } else {
    //             return response()->json(['error' => 'Failed to predict category'], 500);
    //         }

    //         // Store file details in the database
    //         File::create([
    //             'file_name' => $request->input('title'), // Assuming `title` maps to `file_name`
    //             'title' => $request->input('title'),
    //             'file_path' => $filePath,
    //             'content' => $content,
    //             'encoded_content' => json_encode($encodedContent),
    //             'category' => $category,
    //         ]);

    //         if ($request->ajax()) {
    //             // Return JSON response if the request is AJAX
    //             return response()->json([
    //                 'status' => 200,
    //                 'success' => true,
    //                 'data' => [
    //                     'filePath' => $filePath,
    //                     'message' => 'File uploaded successfully'
    //                 ]
    //             ], 200);
    //         } else {
    //             // Redirect back with session data for non-AJAX requests
    //             return redirect()->back()->with([
    //                 'status' => 200,
    //                 'success' => true,
    //                 'filePath' => $filePath,
    //                 'message' => 'File uploaded successfully'
    //             ]);
    //         }
    //     }

    //     // If no file was uploaded, return an error response
    //     return response()->json([
    //         'status' => 400,
    //         'success' => false,
    //         'data' => [
    //             'message' => 'No file uploaded'
    //         ]
    //     ], 400);
    // }
}
