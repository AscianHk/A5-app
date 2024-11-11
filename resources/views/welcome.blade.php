<div style="background: orange; display: flex ">
@auth
{{Auth::user()->name}}
<a href="/logout">Logout</a>
@else
<a href="/login">Login</a>
@endauth
</div>


<div>
    @foreach ($ficheros as $fichero)
        <p>{{$fichero->name}}</p>
    @endforeach

</div>

<table>
    <tr>
        <th>Name</th>
        <th>Size</th>
        <th>Owner</th>
        <th>Created at</th>
        <th>Modified at</th>
        <th></th>
    </tr>
    @foreach($ficheros as $fichero)
    <tr>
        <td><a href="/download/{{$fichero->id}}">{{$fichero->id}}</td>
        <td>{{$fichero->user->name}}</td>
        <td>{{$fichero->Size()}}</td>
        <td>{{$fichero->created_at}}</td>
        <td>{{$fichero->modified_at}}</td>
        <td><a href="/delete/{{$fichero->id}}">Borrar</td>
    </tr>

    @endforeach

</table>



@can('upload', App/Models/Fichero::class)
    
<form method="POST" action="/upload" enctype="multipart/form-data">
    @csrf
    <input type="file" name="uploaded_file">
    <input type="submit" value="Upload">
</form>
@endcan