<?php

namespace App\Http\Controllers;

use App\Models\Cliente;
use App\Models\User;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Http\Request;

class ClienteController extends Controller
{
    public function index()
    {
        $clientes = Cliente::latest()->get();

        return view('clientes.index', compact('clientes'));
    }

    public function create()
    {
        return view('clientes.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'empresa' => 'nullable|max:255',
            'ruc' => 'nullable|digits:11',
            'telefono' => 'nullable|max:20',
            'email' => 'required|email|max:255|unique:users,email',
            'direccion' => 'nullable|max:500',
            'password' => ['required', 'confirmed', 'min:8'],
        ]);

        DB::transaction(function () use ($request) {
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
                'direccion' => $request->direccion,
            ]);
        });

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente registrado correctamente.');
    }

    public function show(string $id)
    {
        $cliente = Cliente::findOrFail($id);

        return view('clientes.show', compact('cliente'));
    }

    public function destroy(string $id)
    {
        $cliente = Cliente::findOrFail($id);

        $cliente->delete();

        return redirect()
            ->route('clientes.index')
            ->with('success', 'Cliente eliminado correctamente.');
    }
}