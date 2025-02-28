<!-- resources/views/edit_metadata.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Metadatos del Fichero</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }

        .form-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .form-group {
            margin-bottom: 15px;
        }

        .form-group label {
            display: block;
            margin-bottom: 5px;
        }

        .form-group input[type="text"],
        .form-group input[type="number"] {
            width: 100%;
            padding: 8px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        .form-group button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            border-radius: 4px;
        }

        .form-group button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<div class="form-container">
    <h1>Editar Metadatos del Fichero</h1>
    <form method="POST" action="{{ route('fichero.updateMetadata', $fichero->id) }}">
        @csrf
        @method('PUT')

        <div class="form-group">
            <label for="name">Nombre del Fichero</label>
            <input type="text" id="name" name="name" value="{{ $fichero->name }}" required>
        </div>

        <div class="form-group">
            <label for="size">Tamaño del Fichero</label>
            <input type="number" id="size" name="size" value="{{ $fichero->size }}" required>
        </div>

        <button type="submit">Guardar Cambios</button>
    </form>
</div>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

</body>
</html>
