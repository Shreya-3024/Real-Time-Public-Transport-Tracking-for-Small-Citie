<?php

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth'])->group(function () {
    Route::get('/passenger', function () {
        return view('passenger.dashboard');
    })->name('passenger.dashboard');

    Route::get('/driver', function () {
        return view('driver.dashboard');
    })->name('driver.dashboard');

    Route::get('/admin', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard')->middleware('admin');
    
    Route::post('/logout', function (Request $request) {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();
        return redirect('/login');
    })->name('logout');
});

Route::get('/login', function () {
    return view('auth.login');
})->name('login');

Route::post('/login', function (Request $request) {
    $credentials = $request->validate([
        'email' => 'required|email',
        'password' => 'required',
    ]);

    if (Auth::attempt($credentials)) {
        $request->session()->regenerate();
        
        $user = Auth::user();
        if ($user->role->name === 'admin') {
            return redirect()->intended('/admin');
        } elseif ($user->role->name === 'driver') {
            return redirect()->intended('/driver');
        } else {
            return redirect()->intended('/passenger');
        }
    }

    return back()->withErrors([
        'email' => 'The provided credentials do not match our records.',
    ]);
});

Route::get('/register', function () {
    return view('auth.register');
})->name('register');

Route::post('/register', function (Request $request) {
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|string|email|max:255|unique:users',
        'password' => 'required|string|min:8|confirmed',
    ]);

    $passengerRole = \App\Models\Role::where('name', 'passenger')->first();
    
    $user = \App\Models\User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => \Illuminate\Support\Facades\Hash::make($request->password),
        'role_id' => $passengerRole->id,
        'phone' => $request->phone ?? '0000000000',
        'is_active' => true,
    ]);

    Auth::login($user);
    $request->session()->regenerate();
    return redirect('/passenger');
});
