<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
</head>
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

    form {
        display: flex;
        flex-direction: column;
        align-items: center;
        background-color: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
        width: 100%;
        max-width: 400px;
        margin: 20px auto;
    }

    form div {
        margin-bottom: 15px;
        width: 100%;
    }

    form label {
        display: block;
        margin-bottom: 5px;
        font-weight: bold;
        color: #4a4a4a;
        font-size: 14px;
    }

    form input {
        width: 100%;
        padding: 10px;
        border: 1px solid #ccc;
        border-radius: 4px;
        font-size: 14px;
        outline: none;
        box-sizing: border-box;
    }

    form input:focus {
        border-color: #8b8c68;
        box-shadow: 0 0 5px rgba(139, 140, 104, 0.5);
    }

    form button {
        background-color: #8b8c68;
        color: white;
        border: none;
        padding: 10px 20px;
        border-radius: 4px;
        font-size: 16px;
        cursor: pointer;
        text-align: center;
        width: 100%;
        max-width: 150px;
    }

    form button:hover {
        background-color: #7a7b61;
    }

    /* Warning Message Styles */
    .error-message {
        color: white;
        background-color: #d9534f; /* Red for error */
        padding: 10px;
        border-radius: 4px;
        font-size: 14px;
        font-weight: bold;
        margin-bottom: 20px;
        text-align: center;
        width: 100%;
        max-width: 400px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.2);
    }

    .error-message ul {
        margin: 0;
        padding: 0;
        list-style: none;
    }

    .error-message li {
        margin-bottom: 5px;
    }

    /* Responsive Design */
    @media (max-width: 480px) {
        form {
            padding: 15px;
        }

        form button {
            font-size: 14px;
        }

        .error-message {
            font-size: 12px;
        }
    }

</style>
<body>
    <div class="logo">
        <img src="{{ asset('images/logo.png') }}" alt="ICT Logo">
        {{-- <div class="divider"></div> --}}
    </div>

    <div class="title">Admin Log In</div>

    @if ($errors->any())
        <div style="color: red;">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form action="{{ route('login') }}" method="POST">
        @csrf
        <div>
            <label>Email:</label>
            <input type="email" name="email" required>
        </div>
        <div>
            <label>Password:</label>
            <input type="password" name="password" required>
        </div>
        <div>
            <button type="submit">Login</button>
        </div>
    </form>
</body>
</html>
