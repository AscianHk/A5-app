<?php


use App\Http\Controllers\FileController;
use App\Http\Controllers\CollectionController;
use App\Models\Fichero;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

Route::get('/', function () {
    return view('welcome')->with('ficheros', Fichero::all());
});

Route::get('/login', function () {
    return view('login');
});

Route::middleware(['auth'])->group(function () {
    Route::post('/upload', [FileController::class, 'upload']);
    Route::get('/download/{id}', [FileController::class, 'download']);
    Route::delete('/delete/{id}', [FileController::class, 'delete']);
    Route::get('/share/{id}', [FileController::class, 'share']);
    Route::get('/preview/{id}', [FileController::class, 'preview'])->name('fichero.preview');
    Route::get('/edit/{id}', [FileController::class, 'edit'])->name('fichero.edit');
    Route::put('/update/{id}', [FileController::class, 'update'])->name('fichero.update');
    Route::get('/versions/{id}', [FileController::class, 'versions'])->name('fichero.versions');
    Route::get('/collections', [CollectionController::class, 'index']);
    Route::post('/collections', [CollectionController::class, 'store']);
    Route::post('/collections/{collectionId}/add-file', [CollectionController::class, 'addFile']);
    Route::delete('/collections/{collectionId}/remove-file/{fileId}', [CollectionController::class, 'removeFile']);

    Route::get('/fichero/{id}/edit_metadata', [FileController::class, 'editMetadata'])->name('fichero.editMetadata');
    Route::put('/fichero/{id}/update_metadata', [FileController::class, 'updateMetadata'])->name('fichero.updateMetadata');
    Route::get('/search', [FileController::class, 'search'])->name('fichero.search');
});

Route::post('/login', function (Illuminate\Http\Request $request) {
    $credentials = $request->validate([
        'email' => ['required', 'email'],
        'password' => ['required'],
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect()->intended('/');
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ])->onlyInput('email');
});

Route::get('/logout', function (Illuminate\Http\Request $request) {
    Auth::logout();
    $request->session()->invalidate();
    $request->session()->regenerateToken();
    return redirect('/');
});

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', function (Illuminate\Http\Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|confirmed',
    ]);

    App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Illuminate\Support\Facades\Hash::make($request->password),
    ]);

    return redirect('/login')->with('success', 'Usuario registrado correctamente. Inicia sesión.');
})->name('register.post');

Route::post('/upload', function (Illuminate\Http\Request $request) {
    if ($request->file('uploaded_file') === null) {
        return redirect('/');
    } else {
        $stored_file = $request->file('uploaded_file')->store();

        $fichero = new Fichero();
        $fichero->path = $stored_file;
        $fichero->name = $request->file('uploaded_file')->getClientOriginalName();
        $fichero->user_id = Auth::user()->id;
        $fichero->save();

        return redirect('/');
    }
});

Route::get('/compartir/{id}', function ($id) {
    $fichero = Fichero::findOrFail($id);
    $signedUrl = URL::temporarySignedRoute(
        'download', now()->addMinutes(30), ['file' => $fichero->id]
    );

    return response()->json(['url' => $signedUrl]);
})->name('compartir');

Route::get('/download/{file}', function (Fichero $file) {
    return Storage::download($file->path, $file->name);
})->name('download');

Route::get('/delete/{file}', function (Fichero $file) {
    Storage::delete($file->path);
    Fichero::destroy($file->id);
    return redirect('/');
})->can('delete', 'file');
