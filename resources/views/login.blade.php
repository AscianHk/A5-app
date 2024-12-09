<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f9;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            height: 100vh;
        }

        .login-form {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            width: 100%;
            max-width: 400px;
            display: flex;
            flex-direction: column;
            gap: 10px;
        }

        .input-field {
            padding: 12px;
            margin-bottom: 10px;
            border: 1px solid #ccc;
            border-radius: 4px;
            font-size: 16px;
            width: 100%;
        }

        .input-field:focus {
            border-color: #007bff;
            outline: none;
        }

        .submit-button {
            padding: 12px;
            background-color: #007bff;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            cursor: pointer;
            transition: background-color 0.3s;
            width: 100%;
        }

        .submit-button:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>

    <form action="/login" method="POST" class="login-form">
        @csrf
        <input type="email" name="email" placeholder="Email" class="input-field">
        <input type="password" name="password" placeholder="Password" class="input-field">
        <input type="submit" value="Login" class="submit-button">
    </form>

</body>
</html>
