<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lomismo Files</title>
    <style>
        body {
            margin: 0;
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
        }

        .header {
            background: #ff6600;
            color: white;
            padding: 15px 20px;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .header h1 {
            margin: 0;
            font-size: 1.8rem;
        }

        .header a {
            color: white;
            text-decoration: none;
            margin-left: 15px;
            font-weight: bold;
        }

        .header a:hover {
            text-decoration: underline;
        }

        table {
            width: 90%;
            margin: 20px auto;
            border-collapse: collapse;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }

        th, td {
            padding: 12px 15px;
            text-align: left;
            border: 1px solid #ddd;
        }

        th {
            background: #ff6600;
            color: white;
        }

        tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .actions a {
            display: inline-block;
            margin-right: 5px;
            padding: 6px 12px;
            background-color: #007bff;
            color: white;
            text-decoration: none;
            border-radius: 4px;
        }

        .actions a:hover {
            background-color: #0056b3;
        }

        button {
            background-color: #28a745;
            color: white;
            border: none;
            padding: 6px 12px;
            cursor: pointer;
            border-radius: 4px;
        }

        button:hover {
            background-color: #218838;
        }

        input {
            width: 300px;
            padding: 5px;
            margin-right: 5px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }

        form {
            width: 90%;
            margin: 20px auto;
            padding: 15px;
            background: white;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            border-radius: 8px;
        }

        form input[type="file"] {
            margin-right: 10px;
        }

        form input[type="submit"] {
            background-color: #007bff;
            color: white;
            border: none;
            padding: 8px;
            border-radius: 4px;
            cursor: pointer;
        }

        form input[type="submit"]:hover {
            background-color: #0056b3;
        }
    </style>
</head>
<body>
<div class="header">
    <h1>Lomismo Files</h1>
    <div>
        @auth
            {{ Auth::user()->name }}
            <a href="/logout">Logout</a>
        @else
            <a href="/login">Login</a>
        @endauth
        @guest
            <a href="/register">Register</a> 
        @endguest
        <button onclick="window.location.href='/collections'">Ver Colecciones</button>
    </div>
</div>

<!-- Añadir el formulario de búsqueda -->
<form method="GET" action="{{ route('fichero.search') }}">
    <input type="text" name="query" placeholder="Buscar ficheros...">
    <input type="submit" value="Buscar">
</form>

<table>
    <tr>
        <th>ID</th>
        <th>Nombre</th>
        <th>Tamaño</th>
        <th>Propietario</th>
        <th>Creado en</th>
        <th>Modificado en</th>
        <th>Acciones</th>
        <th>Borrar</th>
    </tr>
    @foreach($ficheros as $fichero)
    <tr>
        <td>{{ $fichero->id }}</td>
        <td>
            @if (Auth::id() === $fichero->user_id)
                <a href="/download/{{$fichero->id}}">{{$fichero->name}}</a>
            @else
                {{$fichero->name}}
            @endif
        </td>
        <td>{{$fichero->size}}</td>
        <td>{{$fichero->user->name}}</td>
        <td>{{$fichero->created_at}}</td>
        <td>{{$fichero->updated_at}}</td>
        <td class="actions">
            @if (Auth::id() === $fichero->user_id)
                <button onclick="generarUrlCompartir({{$fichero->id}})">Compartir</button>
                <div id="compartir-url-{{$fichero->id}}" style="margin-top: 5px; display: none;">
                    <input type="text" id="url-input-{{$fichero->id}}" readonly>
                    <button onclick="copiarUrl({{$fichero->id}})">Copiar</button>
                </div>
                <a href="{{ route('fichero.preview', $fichero->id) }}">Vista Previa</a>
                <a href="{{ route('fichero.edit', $fichero->id) }}">Editar Contenido</a>
                <a href="{{ route('fichero.editMetadata', $fichero->id) }}">Editar Metadatos</a>
                <a href="{{ route('fichero.versions', $fichero->id) }}">Ver Versiones</a>
            @endif
        </td>
        @can('delete', $fichero)
        <td><a href="/delete/{{$fichero->id}}">Borrar</a></td>
        @endcan
    </tr>
    @endforeach
</table>

@can('upload', App\Models\Fichero::class)
<form method="POST" action="/upload" enctype="multipart/form-data">
    @csrf
    <input type="file" name="uploaded_file">
    <input type="submit" value="Upload">
</form>
@endcan

<script>
    function generarUrlCompartir(fileId) {
        fetch(`/compartir/${fileId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error("Error al obtener la URL.");
                }
                return response.json();
            })
            .then(data => {
                const urlInput = document.getElementById(`url-input-${fileId}`);
                urlInput.value = data.url;

                const compartirDiv = document.getElementById(`compartir-url-${fileId}`);
                compartirDiv.style.display = 'block';
            })
            .catch(error => {
                console.error('Error al generar la URL:', error);
                alert("Error al generar la URL de compartir.");
            });
    }

    function copiarUrl(fileId) {
        const urlInput = document.getElementById(`url-input-${fileId}`);
        urlInput.select();
        document.execCommand('copy');
        alert('URL copiada al portapapeles.');
    }
</script>

</body>
</html>
