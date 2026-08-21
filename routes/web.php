<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ClienteController;
use App\Http\Controllers\ServicioController;
use App\Http\Controllers\CotizacionController;
use App\Http\Controllers\ClienteCotizacionController;
use App\Http\Controllers\HomeController;
use App\Models\User;
use Laravel\Socialite\Facades\Socialite;
use Illuminate\Support\Facades\Auth;



// ---------- Público (landing) ----------
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/servicios-publico', [HomeController::class, 'servicios'])->name('servicios.publico');
Route::get('/contacto', [HomeController::class, 'contacto'])->name('contacto');

// ---------- Autenticación ----------
Route::middleware('guest')->group(function () {
    Route::get('/registro', [AuthController::class, 'showRegister'])->name('register');
    Route::post('/registro', [AuthController::class, 'register']);
    Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
    Route::post('/login', [AuthController::class, 'login']);
});

Route::post('/logout', [AuthController::class, 'logout'])
    ->middleware('auth')
    ->name('logout');

Route::middleware('auth')->group(function () {
    Route::get('/completar-perfil', [AuthController::class, 'showCompleteProfile'])
        ->name('profile.complete');
    Route::post('/completar-perfil', [AuthController::class, 'completeProfile']);
    Route::get('/mi-perfil', [AuthController::class, 'showProfile'])
        ->name('profile.edit');
    Route::put('/mi-perfil', [AuthController::class, 'updateProfile'])
        ->name('profile.update');
});

// ---------- Área cliente (requiere login) ----------
Route::middleware('auth')->group(function () {
    Route::get('/cotizar', [ClienteCotizacionController::class, 'create'])->name('cotizar.create');
    Route::post('/cotizar', [ClienteCotizacionController::class, 'store'])->name('cotizar.store');
    Route::get('/mis-cotizaciones', [ClienteCotizacionController::class, 'index'])->name('mis-cotizaciones.index');
    Route::get('/mis-cotizaciones/{cotizacion}', [ClienteCotizacionController::class, 'show'])->name('mis-cotizaciones.show');
});

Route::get('/google-auth/redirect', function () {
    return Socialite::driver('google')->redirect();
})->middleware('guest')->name('google.redirect');
 
Route::get('/google-auth/callback', function () {
    $user_google = Socialite::driver('google')->user();

    $user = User::firstOrNew([
        'email' => $user_google->email,
    ]);

    $user->name = $user_google->name;
    $user->google_id = $user_google->id;

    if (! $user->exists) {
        $user->password = null;
        $user->role = 'cliente';
    }

    $user->save();

    Auth::login($user, true);

    if (! $user->isAdmin()) {
        $cliente = $user->cliente;

        if (! $cliente || ! $cliente->empresa || ! $cliente->ruc || ! $cliente->telefono) {
            return redirect()->route('profile.complete');
        }
    }

    return redirect()->intended(
        $user->isAdmin() ? route('clientes.index') : route('home')
    );
})->middleware('guest')->name('google.callback');

// ---------- Panel admin (requiere login + rol admin) ----------
Route::middleware(['auth', 'admin'])->group(function () {
    Route::resource('clientes', ClienteController::class)->except(['edit', 'update']);
    Route::resource('cotizaciones', CotizacionController::class)
        ->parameters(['cotizaciones' => 'cotizacion']);
    Route::resource('servicios', ServicioController::class);
    Route::delete('/servicios/{servicio}/imagenes/{imagen}', [ServicioController::class, 'destroyImage'])
        ->name('servicios.imagenes.destroy');
});
