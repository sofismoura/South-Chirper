<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;
use App\Models\Chirp;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// 🏠 HOME
Route::get('/', function () {
    $chirps = Chirp::with('user')->latest()->get();
    return view('home', compact('chirps'));
});


// ==========================
// 📝 SIGNUP
// ==========================

// abrir página
Route::get('/signup', function () {
    return view('signup');
});

// salvar usuário + FOTO
Route::post('/signup', function (Request $request) {

    $request->validate([
        'name' => 'required',
        'email' => 'required|email|unique:users',
        'password' => 'required|min:4',
        'photo' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
    ]);

    $path = null;

    // 📸 salvar imagem
    if ($request->hasFile('photo')) {
        $path = $request->file('photo')->store('photos', 'public');
    }

    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($request->password),
        'photo' => $path
    ]);

    // 🔥 login automático
    Auth::login($user);

    return redirect('/');
});


// ==========================
// 🔐 LOGIN
// ==========================

// abrir página
Route::get('/login', function () {
    return view('login');
});

// processar login
Route::post('/login', function (Request $request) {

    $credentials = $request->only('email', 'password');

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        return redirect('/');
    }

    return back()->withErrors([
        'email' => 'Email ou senha inválidos'
    ]);
});


// ==========================
// 🔓 LOGOUT
// ==========================

Route::post('/logout', function (Request $request) {
    Auth::logout();

    $request->session()->invalidate();
    $request->session()->regenerateToken();

    return redirect('/');
});


// ==========================
// 🐦 CHIRPS (POST)
// ==========================

Route::post('/chirps', function (Request $request) {

    // 🔒 precisa estar logado
    if (!auth()->check()) {
        return redirect('/login');
    }

    $request->validate([
        'message' => 'required|max:255'
    ]);

    Chirp::create([
        'user_id' => auth()->id(), // 👤 usuário real
        'message' => $request->message
    ]);

    return redirect('/');
});