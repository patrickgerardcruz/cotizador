<?php

namespace App\Http\Controllers;

use App\Models\Cotizacion;
use App\Models\Cliente;
use App\Models\Servicio;
use Illuminate\Http\Request;

class CotizacionController extends Controller
{
public function index()
{
    $cotizaciones = Cotizacion::with('cliente')
        ->latest()
        ->get();

    return view('cotizaciones.index', compact('cotizaciones'));
}

    public function create()
    {
        $clientes = Cliente::all();
        $servicios = Servicio::where('estado', true)->get();

        return view('cotizaciones.create', compact('clientes', 'servicios'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'cliente_id' => 'required|exists:clientes,id',
            'fecha' => 'required|date',
            'validez' => 'nullable|date',
            'servicios' => 'required|array|min:1',
            'servicios.*.servicio_id' => 'required|exists:servicios,id',
            'servicios.*.cantidad' => 'required|integer|min:1',
        ]);

        $cotizacion = Cotizacion::create([
            'cliente_id' => $request->cliente_id,
            'numero' => 'COT-' . date('YmdHis'),
            'fecha' => $request->fecha,
            'validez' => $request->validez,
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
            ->route('cotizaciones.show', $cotizacion)
            ->with('success', 'Cotización creada correctamente.');
    }

    public function show(Cotizacion $cotizacion)
    {
        $cotizacion->load(['cliente', 'detalles.servicio']);

        return view('cotizaciones.show', compact('cotizacion'));
    }

    public function edit(Cotizacion $cotizacion)
    {
        $cotizacion->load('detalles.servicio');

        return view('cotizaciones.edit', compact('cotizacion'));
    }

    public function update(Request $request, Cotizacion $cotizacion)
    {
        $data = $request->validate([
            'observaciones' => 'nullable|string|max:1000',
            'estado' => 'required|in:pendiente,en proceso,entregado',
        ]);

        $cotizacion->update($data);

        return redirect()
            ->route('cotizaciones.show', $cotizacion)
            ->with('success', 'Cotización actualizada correctamente.');
    }

    public function destroy(Cotizacion $cotizacion)
    {
        $cotizacion->delete();

        return redirect()
            ->route('cotizaciones.index')
            ->with('success', 'Cotización eliminada correctamente.');
    }
}