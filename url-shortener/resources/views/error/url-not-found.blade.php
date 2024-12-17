<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Error - URL Not Found</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
            margin: 0;
            background-color: #f2f2f2;
        }
        .error-container {
            text-align: center;
            padding: 20px;
            background-color: #fff;
            border: 1px solid #ccc;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        h1 {
            color: #d9534f;
        }
        p {
            color: #555;
        }
    </style>
</head>
<body>

    <div class="error-container">
        <h1>Error</h1>
        <p>{{ $message }}</p>
        <a href="{{ url('/') }}" style="color: #007bff;">Go back to home</a>
    </div>

</body>
</html>
