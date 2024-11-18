<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infracom Technology</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <style>
        /* General Styles */
        body {
            background-color: #BFBD90;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 100vh;
            margin: 0;
            padding: 0;
            font-family: Arial, sans-serif;
        }

        .logo {
            position: fixed;
            top: 10px;
            left: 10%;
            max-width: 100%; /* Ensure the image doesn’t exceed the container */
            height: auto;
        }

        .logo img {
            width: 25%;
            max-width: 25%; /* Ensure the image doesn’t exceed the container */
            height: auto;
            object-fit: cover;
        }

        @media (max-width: 768px) {
            .logo {
                width: 25%; /* Adjust size for tablets or smaller screens */
                height: auto;
            }
        }

        @media (max-width: 480px) {
            .logo {
                width: 25; /* Adjust size for mobile devices */
                height: auto;
            }
        }

        @media (max-height: 300px) {
            .logo {
                display: none; /* Hide the logo on tablets and smaller screens */
            }
        }

        .divider {
            width: 450%;
            height: 2px;
            background-color: #b8b58a;
            margin-top: 10px;
        }
        .title {
            font-size: 36px;
            font-weight: bold;
            margin-bottom: 20px;
        }

        /* Search Bar */
        .search-bar {
            display: inline-block;
            align-items: center;
            background-color: white;
            padding: 10px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
            margin-bottom: 20px;
        }
        .search-bar input {
            border: none;
            outline: none;
            font-size: 16px;
            flex: 1;
            white-space: nowrap;
            max-width: 800px;
            width: 100%;
        }
        .search-bar button {
            background-color: #cdc9a1;
            border: none;
            padding: 0;
            cursor: pointer;
            outline: none;
            display: flex;
            align-items: center;
            justify-content: center;
            width: 36px;
            height: 36px;
            border-radius: 8px;
        }
        .search-bar button i {
            font-size: 16px;
            color: black;
        }

        /* Upload Button */
        .upload-button {
            background-color: #8b8c68;
            color: white;
            border: none;
            padding: 10px 20px;
            border-radius: 8px;
            margin-top: 20px;
            font-size: 16px;
            cursor: pointer;
            text-decoration: none;
            text-align: center;
        }
        .upload-button:hover {
            background-color: #7a7b61;
        }

        /* Search Results */
        .search-results {
            background-color: #fff;
            width: 100%;
            max-width: 800px;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            margin-top: 20px;
        }
        .search-results h1 {
            font-size: 24px;
            color: #333;
            margin-bottom: 15px;
            text-align: center;
        }
        .search-results .error-message {
            color: red;
            text-align: center;
            margin-bottom: 10px;
        }
        .result-item {
            border-bottom: 1px solid #ddd;
            padding: 15px 0;
        }
        .result-item:last-child {
            border-bottom: none;
        }
        .result-item strong {
            font-size: 16px;
        }
        .result-item .download-link {
            display: inline-block;
            margin-top: 10px;
            background-color: #8b8c68;
            color: white;
            padding: 8px 16px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 14px;
        }
        .result-item .download-link:hover {
            background-color: #7a7b61;
        }
    </style>
</head>
<body>
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="ICT Logo">
        {{-- <div class="divider"></div> --}}
    </div>

    <div class="title">Infracom Technology</div>

    <div class="search-bar">
        <form action="{{ route('search_pdf') }}" method="POST">
            @csrf
            <input type="text" name="query" placeholder="Input a keyword" required>
            <button type="submit">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>

    @if (auth()->guard('admin')->check())  <!-- Check if the admin user is logged in -->
        <a href="{{ url('/upload-form') }}" class="upload-button">Upload Document</a>
    @endif

    <!-- Search Results Section -->
    <div class="search-results">
        <h1>Search Results</h1>

        @if(session('error'))
            <p class="error-message">{{ session('error') }}</p>
        @endif

        <p><strong>Response:</strong> {{ $response }}</p>

        <ul>
            @php
                $filteredDocuments = collect($documents)->filter(function ($doc) {
                    return $doc['overall_score'] >= 0.5;
                });
            @endphp

            @if($filteredDocuments->isEmpty())
                <li>No document is recommended</li>
            @else
                @foreach($filteredDocuments as $doc)
                    <li class="result-item">
                        <strong>Document:</strong> {{ $doc['name'] }} <br>
                        <strong>Overall Score:</strong> {{ $doc['overall_score'] }} <br>
                        <strong>Content Score:</strong> {{ $doc['content_score'] }} <br>
                        <strong>Category Score:</strong> {{ $doc['category_score'] }} <br>

                        <!-- Download or Access Link -->
                        <a href="{{ url('storage/' . $doc['path']) }}" target="_blank" class="download-link">Access Document</a>
                        <!-- Download or Access Link -->
                        <a href="{{ url('storage/' . $doc['path']) }}" download="{{ $doc['name'] }}" class="download-link">Download Document</a>
                    </li>
                @endforeach
            @endif
        </ul>


        <div style="text-align: center; margin-top: 20px;">
            <a href="{{ url('/') }}">Back to Search</a>
        </div>
    </div>
</body>
</html>
