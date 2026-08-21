<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClienteCotizacionController extends Controller
{
    public function create()
    {
        $servicios = Servicio::with('imagenes')
            ->where('estado', true)
            ->orderBy('nombre')
            ->get();

        return view('cotizar.create', compact('servicios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'servicios' => 'required|array|min:1',
            'servicios.*.servicio_id' => 'required|exists:servicios,id',
            'servicios.*.cantidad' => 'required|integer|min:1',
            'observaciones' => 'nullable|string|max:1000',
        ]);

        $user = Auth::user();
        $cliente = $user->cliente;

        // Por si el usuario fue creado antes de vincular clientes con user_id
        if (! $cliente) {
            $cliente = $user->cliente()->create([
                'nombre' => $user->name,
                'email' => $user->email,
            ]);
        }

        $cotizacion = Cotizacion::create([
            'cliente_id' => $cliente->id,
            'numero' => 'COT-' . date('YmdHis'),
            'fecha' => now()->toDateString(),
            'validez' => now()->addDays(15)->toDateString(),
            'subtotal' => 0,
            'descuento' => 0,
            'igv' => 0,
            'total' => 0,
            'estado' => 'pendiente',
            'observaciones' => $request->observaciones,
        ]);

        $subtotal = 0;

        foreach ($request->servicios as $item) {
            $servicio = Servicio::findOrFail($item['servicio_id']);
            $cantidad = $item['cantidad'];
            $precio = $servicio->precio;
            $totalItem = $cantidad * $precio;

            $cotizacion->detalles()->create([
                'servicio_id' => $servicio->id,
                'cantidad' => $cantidad,
                'precio' => $precio,
                'subtotal' => $totalItem,
            ]);

            $subtotal += $totalItem;
        }

        $igv = $subtotal * 0.18;
        $total = $subtotal + $igv;

        $cotizacion->update([
            'subtotal' => $subtotal,
            'igv' => $igv,
            'total' => $total,
        ]);

        return redirect()
            ->route('mis-cotizaciones.show', $cotizacion)
            ->with('success', 'Tu solicitud de cotización fue enviada correctamente.');
    }

    public function index()
    {
        $cliente = Auth::user()->cliente;

        $cotizaciones = $cliente
            ? $cliente->cotizaciones()->latest()->get()
            : collect();

        return view('cotizar.index', compact('cotizaciones'));
    }

    public function show(Cotizacion $cotizacion)
    {
        $cliente = Auth::user()->cliente;

        abort_unless($cliente && $cotizacion->cliente_id === $cliente->id, 403);

        $cotizacion->load('detalles.servicio');

        return view('cotizar.show', compact('cotizacion'));
    }
}