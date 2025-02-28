<!-- resources/views/versions.blade.php -->

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Versiones de ficheros</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            color: #333;
            padding: 20px;
        }

        .version {
            background-color: #fff;
            padding: 20px;
            margin-bottom: 10px;
            border-radius: 8px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
        }

        .version h2 {
            margin: 0;
            font-size: 1.2em;
            color: #555;
        }

        .version pre {
            white-space: pre-wrap;
            word-wrap: break-word;
            margin: 0;
        }
    </style>
</head>
<body>

<h1>Versiones anteriores de {{ $fichero->name }}</h1>

@foreach($versions as $version)
    <div class="version">
        <h2>Versión del {{ $version->created_at }}</h2>
        <pre>{{ $version->content }}</pre>
    </div>
@endforeach

</body>
</html>
