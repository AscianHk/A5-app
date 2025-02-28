<!-- resources/views/edit.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar fichero</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }

        .editor {
            width: 100%;
            height: 400px;
            white-space: pre-wrap;
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border: 1px solid #ddd;
        }

        .editor:focus {
            outline: none;
        }

        .save-button {
            display: inline-block;
            margin-top: 10px;
            padding: 10px 20px;
            background-color: #28a745;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            text-decoration: none;
        }

        .save-button:hover {
            background-color: #218838;
        }
    </style>
</head>
<body>

<form method="POST" action="{{ route('fichero.update', $fichero->id) }}">
    @csrf
    @method('PUT')
    <textarea name="content" class="editor">{{ $content }}</textarea>
    <button type="submit" class="save-button">Guardar</button>
</form>

@if(session('success'))
    <p>{{ session('success') }}</p>
@endif

</body>
</html>
