<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class AuthController extends Controller
{
    public function showRegister()
    {
        return view('auth.register');
    }

    public function register(Request $request)
    {
        $request->validate([
            'nombre' => 'required|string|max:255',
            'empresa' => 'required|string|max:255',
            'ruc' => 'required|digits:11',
            'telefono' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email',
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user = User::create([
            'name' => $request->nombre,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => 'cliente',
        ]);

        Cliente::create([
            'user_id' => $user->id,
            'nombre' => $request->nombre,
            'empresa' => $request->empresa,
            'ruc' => $request->ruc,
            'telefono' => $request->telefono,
            'email' => $request->email,
        ]);

        Auth::login($user);

        return redirect()->route('home')->with('success', '¡Bienvenido! Tu cuenta fue creada correctamente.');
    }

    public function showLogin()
    {
        return view('auth.login');
    }

    public function showCompleteProfile()
    {
        return view('auth.complete-profile', [
            'cliente' => Auth::user()->cliente,
        ]);
    }

    public function completeProfile(Request $request)
    {
        $data = $request->validate([
            'empresa' => 'required|string|max:255',
            'ruc' => 'required|digits:11',
            'telefono' => 'required|string|max:20',
        ]);

        $user = Auth::user();

        $user->cliente()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'nombre' => $user->name,
                'empresa' => $data['empresa'],
                'ruc' => $data['ruc'],
                'telefono' => $data['telefono'],
                'email' => $user->email,
            ]
        );

        return redirect()->intended(route('home'))
            ->with('success', 'Datos completados correctamente.');
    }

    public function login(Request $request)
    {
        $credentials = $request->validate([
            'email' => 'required|email',
            'password' => 'required',
        ]);

        if (! Auth::attempt($credentials, $request->boolean('remember'))) {
            return back()->withErrors([
                'email' => 'Las credenciales no coinciden con nuestros registros.',
            ])->onlyInput('email');
        }

        $request->session()->regenerate();

        $user = Auth::user();

        if ($user->isAdmin()) {
            return redirect()->intended(route('clientes.index'));
        }

        return redirect()->intended(route('home'));
    }


    public function showProfile()
    {
        return view('auth.profile', [
            'cliente' => Auth::user()->cliente,
        ]);
    }

    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $data = $request->validate([
            'telefono' => 'required|string|max:20',
            'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
        ]);

        $user->update([
            'email' => $data['email'],
        ]);

        $user->cliente()->updateOrCreate(
            ['user_id' => $user->id],
            [
                'nombre' => $user->name,
                'telefono' => $data['telefono'],
                'email' => $data['email'],
            ]
        );

        return back()->with('success', 'Perfil actualizado correctamente.');
    }
    public function logout(Request $request)
    {
        Auth::logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect()->route('home');
    }
}