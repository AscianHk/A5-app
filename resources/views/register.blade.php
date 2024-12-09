<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Usuario</title>
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

        .register-form {
            background-color: white;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            width: 350px;
        }

        .register-form h1 {
            text-align: center;
            margin-bottom: 20px;
        }

        .register-form input {
            width: 100%;
            padding: 10px;
            margin: 8px 0;
            border: 1px solid #ccc;
            border-radius: 4px;
        }

        .register-form button {
            width: 100%;
            background-color: #007bff;
            color: white;
            border: none;
            padding: 10px;
            margin-top: 10px;
            cursor: pointer;
            border-radius: 4px;
        }

        .register-form button:hover {
            background-color: #0056b3;
        }

        .error {
            color: red;
            font-size: 0.9em;
        }
    </style>
</head>
<body>

<div class="register-form">
    <h1>Registro</h1>
    <form method="POST" action="{{ route('register.post') }}">
        @csrf

        <input type="text" name="name" placeholder="Nombre" value="{{ old('name') }}" required>
        @error('name')
            <div class="error">{{ $message }}</div>
        @enderror

        <input type="email" name="email" placeholder="Correo electrónico" value="{{ old('email') }}" required>
        @error('email')
            <div class="error">{{ $message }}</div>
        @enderror

        <input type="password" name="password" placeholder="Contraseña" required>
        @error('password')
            <div class="error">{{ $message }}</div>
        @enderror

        <input type="password" name="password_confirmation" placeholder="Confirmar contraseña" required>

        <button type="submit">Registrarse</button>
    </form>
</div>

</body>
</html>
