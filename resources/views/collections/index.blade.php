<style>
    body {
        margin: 0;
        font-family: Arial, sans-serif;
        background-color: #f7f7f7;
        color: #333;
    }

    .container {
        width: 80%;
        margin: 0 auto;
        padding: 20px;
        background-color: #fff;
        box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        border-radius: 8px;
    }

    h1 {
        text-align: center;
        color: #ff6600;
        font-size: 2.4em;
        margin-bottom: 20px;
    }

    form {
        display: flex;
        justify-content: center;
        margin-bottom: 20px;
    }

    form input[type="text"] {
        width: 300px;
        padding: 10px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-right: 10px;
    }

    form button {
        background-color: #ff6600;
        color: white;
        border: none;
        padding: 10px 20px;
        cursor: pointer;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    form button:hover {
        background-color: #e65500;
    }

    ul {
        list-style-type: none;
        padding: 0;
    }

    ul li {
        padding: 10px;
        border-bottom: 1px solid #ddd;
        display: flex;
        justify-content: space-between;
        align-items: center;
    }

    ul li:nth-child(even) {
        background-color: #f9f9f9;
    }

    ul li form {
        margin: 0;
    }

    ul li form input[type="text"] {
        width: 200px;
        padding: 5px;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-right: 5px;
    }

    ul li form button {
        background-color: #007bff;
        color: white;
        border: none;
        padding: 5px 10px;
        cursor: pointer;
        border-radius: 4px;
        transition: background-color 0.3s;
    }

    ul li form button:hover {
        background-color: #0056b3;
    }

    .success {
        color: green;
        font-weight: bold;
        text-align: center;
        margin-bottom: 20px;
    }
</style>

<div class="container">
    <h1>Colecciones</h1>
    @if(session('success'))
        <div class="success">{{ session('success') }}</div>
    @endif
    <form action="/collections" method="POST">
        @csrf
        <input type="text" name="name" placeholder="Nombre de la colección" required>
        <button type="submit">Crear Colección</button>
    </form>

    <ul>
        @foreach ($colecciones as $colección)
            <li>
                <strong>{{ $colección->name }}</strong>

                @if ($colección->ficheros->isNotEmpty())
                    <ul>
                        @foreach ($colección->ficheros as $fichero)
                            <li>{{ $fichero->name }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No hay archivos en esta colección.</p>
                @endif

                <form action="/collections/{{ $colección->id }}/add-file" method="POST" style="display: inline;">
                    @csrf
                    <input type="text" name="file_id" placeholder="ID del fichero" required>
                    <button type="submit">Añadir Fichero</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>

