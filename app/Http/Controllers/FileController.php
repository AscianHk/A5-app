<?php

// App\Http\Controllers\FileController.php

namespace App\Http\Controllers;

use App\Models\Fichero;
use App\Models\Version;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Gate;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

class FileController extends Controller
{
    public function upload(Request $request)
    {
        if (Gate::denies('upload', Fichero::class)) {
            abort(403);
        }

        $path = $request->file('uploaded_file')->store('files');
        $fichero = new Fichero();
        $fichero->path = $path;
        $fichero->name = $request->file('uploaded_file')->getClientOriginalName();
        $fichero->user_id = Auth::id();
        $fichero->save();

        return response()->json(['path' => $path]);
    }

    public function download($id)
    {
        $fichero = Fichero::findOrFail($id);

        if (Gate::denies('view', $fichero)) {
            abort(403);
        }

        return Storage::download($fichero->path, $fichero->name);
    }

    public function delete($id)
    {
        $fichero = Fichero::findOrFail($id);

        if (Gate::denies('delete', $fichero)) {
            abort(403);
        }

        Storage::delete($fichero->path);
        $fichero->delete();

        return response()->json(['message' => 'File deleted']);
    }

    public function share($id)
    {
        $fichero = Fichero::findOrFail($id);

        if (Gate::denies('share', $fichero)) {
            abort(403);
        }

        $signedUrl = URL::temporarySignedRoute(
            'download', now()->addMinutes(30), ['file' => $fichero->id]
        );

        return response()->json(['url' => $signedUrl]);
    }

   

    public function preview($id){
        $fichero = Fichero::findOrFail($id);

        if (Gate::denies('view', $fichero)) {
            abort(403);
        }

        if (in_array(pathinfo($fichero->name, PATHINFO_EXTENSION), ['txt', 'md', 'html'])) {
            $content = Storage::get($fichero->path);
            return view('preview', compact('content'));
        }

        return response()->json(['message' => 'File type not supported for preview'], 400);
    
    }
    public function edit($id)
    {
        $fichero = Fichero::findOrFail($id);

        if (Gate::denies('edit', $fichero)) {
            abort(403);
        }

        if (in_array(pathinfo($fichero->name, PATHINFO_EXTENSION), ['txt', 'md', 'html'])) {
            $content = Storage::get($fichero->path);
            return view('edit', compact('fichero', 'content'));
        }

        return response()->json(['message' => 'File type not supported for editing'], 400);
    }

    public function update(Request $request, $id)
    {
        $fichero = Fichero::findOrFail($id);

        if (Gate::denies('edit', $fichero)) {
            abort(403);
        }

        $request->validate(['content' => 'required|string']);


        $oldContent = Storage::get($fichero->path);
        Version::create(['fichero_id' => $fichero->id, 'content' => $oldContent]);

        Storage::put($fichero->path, $request->input('content'));

        return redirect()->back()->with('success', 'Fichero actualizado exitosamente.');
    }
    public function versions($id)
    {
        $fichero = Fichero::findOrFail($id);
        $versions = Version::where('fichero_id', $id)->get();

        

        return view('versions', compact('fichero', 'versions'));
    }

    public function editMetadata($id)
    {
        $fichero = Fichero::findOrFail($id);

        

        return view('edit_metadata', compact('fichero'));
    }

    public function updateMetadata(Request $request, $id){
        $fichero = Fichero::findOrFail($id);

        if (Gate::denies('edit', $fichero)) {
            abort(403);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'size' => 'required|integer',
        ]);

        $fichero->name = $request->input('name');
        $fichero->size = $request->input('size');
        $fichero->save();

        return redirect()->route('fichero.editMetadata', $fichero->id)->with('success', 'Metadatos actualizados exitosamente.');
    }
    public function search(Request $request)
    {
        $query = $request->input('query');
        $ficheros = Fichero::where('name', 'LIKE', "%{$query}%")
            ->where('user_id', Auth::id())
            ->get();

        return view('welcome', compact('ficheros'));
    }
}