<?php
use App\Models\User;
use App\Models\Fichero;
use Illuminate\Contracts\Routing\UrlGenerator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\URL;

Route::get('/', function () {
    return view('welcome')->with('ficheros', Fichero::all());
});

Route::get('/login',function(){
    return view('login');
});

Route::get('/download/{file}', function(Fichero $file){
    return Storage::download($file->path, $file->name);
})->name('download'); 


Route::get('/delete/{file}', function(Fichero $file){
    Storage::delete($file->path);
    Fichero::destroy($file->id);
    return redirect('/');
})->can('delete','file');



Route::post('/login', function(Request $request){
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

Route::get('/logout', function(Request $request){
    Auth::logout();
 
    $request->session()->invalidate();
 
    $request->session()->regenerateToken();
 
    return redirect('/');
});

Route::get('/compartir/{id}', function ($id) {
    $file = Fichero::findOrFail($id);
    $signedUrl = URL::temporarySignedRoute(
        'download', now()->addMinutes(30), ['file' => $file->id]
    );

    return response()->json(['url' => $signedUrl]);
})->name('compartir');

Route::get('/register', function () {
    return view('register');
})->name('register');

Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'password' => 'required|string|confirmed',
    ]);

    User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
    ]);


    return redirect('/login')->with('success', 'Usuario registrado correctamente. Inicia sesión.');
})->name('register.post');




Route::post('/upload', function(Request $request){
    
if ($request->file('uploaded_file') === null){
return redirect('/');
}

else{
$stored_file = $request->file('uploaded_file')->store();

$fichero = new Fichero();

$fichero->path = $stored_file;
$fichero->name = $request->file('uploaded_file')->getClientOriginalName();
$fichero->user_id = Auth::user()->id;
$fichero->save();

return redirect('/');
}
});