<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Infracom Technology</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-icons/1.10.5/font/bootstrap-icons.min.css">
    <style>
        body {
            background-color: #BFBD90;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            height: 100vh;
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

        .search-bar {
            display: inline-block;
            align-items: center;
            background-color: white;
            padding: 10px 20px;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            max-width: 800px;
            width: 100%;
        }

        .search-bar input {
            border: none;
            outline: none;
            font-size: 16px;
            flex: 1;
            min-width: 0;
            white-space: nowrap;
            max-width: 800px;
            width: 100%;
        }

        .search-bar button {
            background-color: #cdc9a1; /* Button color */
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
            font-size: 16px; /* Adjust icon size */
            font-weight: 700;
            color: black; /* Icon color */
        }

        .upload-button {
            background-color: #8b8c68; /* Button color */
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

        .auth-button {
        position: fixed;
        top: 10px;
        right: 10%;
        background-color: #8b8c68; /* Button color */
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 8px;
        margin-top: 20px;
        font-size: 16px;
        cursor: pointer;
        text-decoration: none;
        text-align: center;
        display: inline-block;
        }

        .auth-button:hover {
            background-color: #7a7b61;
        }

    </style>
</head>
<body>
    <!-- Logout/Login Button -->
    @if (auth()->guard('admin')->check())
        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
            @csrf
            <button type="submit" class="auth-button">Logout</button>
        </form>
    @else
        <a href="{{ route('login') }}" class="auth-button">Log In</a>
    @endif

    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="ICT Logo">
        {{-- <div class="divider"></div> --}}
    </div>

    <div class="title">Infracom Technology</div>

    <div class="search-bar">
        <form action="{{ route('search_pdf') }}" method="POST">
            @csrf
            <input type="text" name="query" placeholder="Input a keyword" required width="100%">
            <button type="submit">
                <i class="bi bi-search"></i>
            </button>
        </form>
    </div>

    <!-- Upload Data Button -->
    @if (auth()->guard('admin')->check())  <!-- Check if the admin user is logged in -->
        <a href="{{ url('/upload-form') }}" class="upload-button">Upload Document</a>
    @endif

</body>
</html>
