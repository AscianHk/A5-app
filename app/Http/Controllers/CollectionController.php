<?php

namespace App\Http\Controllers;

use App\Models\Colección;
use App\Models\Fichero;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CollectionController extends Controller
{
    public function index(){
        $colecciones = Colección::where('user_id', Auth::id())->with('ficheros')->get();
        return view('collections.index', compact('colecciones'));
    }

    public function store(Request $request){
            $request->validate([
                'name' => 'required|string|max:255',
            ]);
    
            $colección = new Colección();
            $colección->name = $request->name;
            $colección->user_id = Auth::id(); 
            $colección->save();
    
            return redirect()->back()->with('success', 'Colección creada exitosamente.');
    }

    public function addFile($collectionId, Request $request){
        $colección = Colección::findOrFail($collectionId);
        $fileId = $request->input('file_id');
        $colección->ficheros()->attach($fileId);

        return redirect()->back()->with('success', 'Fichero añadido a la colección.');
    }

    public function removeFile($collectionId, $fileId){
        $colección = Colección::findOrFail($collectionId);
        $colección->ficheros()->detach($fileId);

        return redirect()->back()->with('success', 'Fichero removido de la colección.');
    }
}
