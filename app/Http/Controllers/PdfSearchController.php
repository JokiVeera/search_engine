<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class PdfSearchController extends Controller
{
    public function searchPdf(Request $request)
    {
        $query = $request->input('query');

        // Send a POST request to the Flask API
        $response = Http::post('http://127.0.0.1:5000/search_pdf', [
            'query' => $query
        ]);

        if ($response->successful()) {
            $data = $response->json();

            // Separate the unique response and the document details
            $uniqueResponse = $data['response'];
            $documents = [];
            foreach ($data['retrieved_docs'] as $index => $doc) {
                $documents[] = [
                    'name' => $doc,
                    'path' => $data['paths'][$index],
                    'overall_score' => $data['overall_scores'][$index],
                    'content_score' => $data['content_scores'][$index],
                    'category_score' => $data['category_scores'][$index]
                ];
            }

            // Pass data to the view
            return view('search_results', [
                'response' => $uniqueResponse,
                'documents' => $documents
            ]);
        } else {
            return redirect()->back()->with('error', 'Error fetching search results.');
        }
    }

}
