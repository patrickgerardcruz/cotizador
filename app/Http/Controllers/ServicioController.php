<?php

namespace App\Http\Controllers;

use App\Models\Servicio;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ServicioController extends Controller
{
    public function index()
    {
        $servicios = Servicio::with('imagenes')->latest()->get();

        return view('servicios.index', compact('servicios'));
    }

    public function create()
    {
        return view('servicios.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable|max:1000',
            'precio' => 'required|numeric|min:0',
            'fotos' => 'nullable|array|max:8',
            'fotos.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $servicio = Servicio::create([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'estado' => true,
        ]);

        $this->guardarImagenes($servicio, $request);

        return redirect()
            ->route('servicios.index')
            ->with('success', 'Servicio registrado correctamente.');
    }

    public function show(string $id)
    {
        $servicio = Servicio::with('imagenes')->findOrFail($id);

        return view('servicios.show', compact('servicio'));
    }

    public function edit(string $id)
    {
        $servicio = Servicio::with('imagenes')->findOrFail($id);

        return view('servicios.edit', compact('servicio'));
    }

    public function update(Request $request, string $id)
    {
        $servicio = Servicio::findOrFail($id);

        $request->validate([
            'nombre' => 'required|max:255',
            'descripcion' => 'nullable|max:1000',
            'precio' => 'required|numeric|min:0',
            'estado' => 'required|boolean',
            'fotos' => 'nullable|array|max:8',
            'fotos.*' => 'image|mimes:jpg,jpeg,png,webp|max:5120',
        ]);

        $servicio->update([
            'nombre' => $request->nombre,
            'descripcion' => $request->descripcion,
            'precio' => $request->precio,
            'estado' => $request->estado,
        ]);

        $this->guardarImagenes($servicio, $request);

        return redirect()
            ->route('servicios.index')
            ->with('success', 'Servicio actualizado correctamente.');
    }

    public function destroy(string $id)
    {
        $servicio = Servicio::findOrFail($id);

        foreach ($servicio->imagenes as $imagen) {
            Storage::disk('public')->delete($imagen->ruta);
        }

        $servicio->delete();

        return redirect()
            ->route('servicios.index')
            ->with('success', 'Servicio eliminado correctamente.');
    }

    public function destroyImage(string $servicioId, string $imagenId)
    {
        $imagen = Servicio::findOrFail($servicioId)
            ->imagenes()
            ->findOrFail($imagenId);

        Storage::disk('public')->delete($imagen->ruta);
        $imagen->delete();

        return back()->with('success', 'Imagen eliminada correctamente.');
    }

    private function guardarImagenes(Servicio $servicio, Request $request): void
    {
        if (! $request->hasFile('fotos')) {
            return;
        }

        foreach ($request->file('fotos') as $foto) {
            if (! $foto->isValid()) {
                continue;
            }

            $servicio->imagenes()->create([
                'ruta' => $foto->store('servicios', 'public'),
                'nombre_original' => $foto->getClientOriginalName(),
            ]);
        }
    }
}