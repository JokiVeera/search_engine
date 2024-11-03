<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\File;

class FileController extends Controller
{

    public function store(Request $request)
    {
        // Validate the request
        $request->validate([
            'file' => 'required|file|mimes:pdf|max:51200',  // PDF files up to 50 MB
            'title' => 'required|string|max:255',           // Title validation
        ]);

        // Handle file upload and saving file path
        if ($request->file('file')) {
            $filePath = $request->file('file')->store('uploads', 'public'); // Stores file in storage/app/public/uploads

            // Placeholder values for `content`, `encoded_content`, and `category` fields
            $content = "Placeholder content"; // Replace with content from the Python API
            $encodedContent = "Placeholder encoded content"; // Replace with encoded content from Python API
            $category = "Placeholder category"; // Replace with category from Python API

            // Store file details in the database
            File::create([
                'file_name' => $request->input('title'), // Assuming `title` maps to `file_name`
                'title' => $request->input('title'),
                'file_path' => $filePath,
                'content' => $content,
                'encoded_content' => $encodedContent,
                'category' => $category,
            ]);

            // Return a standardized JSON response
            return response()->json([
                'status' => 200,
                'success' => true,
                'data' => [
                    'filePath' => $filePath,
                    'message' => 'File uploaded successfully'
                ]
            ], 200);
        }

        // If no file was uploaded, return an error response
        return response()->json([
            'status' => 400,
            'success' => false,
            'data' => [
                'message' => 'No file uploaded'
            ]
        ], 400);
    }
}
