<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServicioImagen extends Model
{
    protected $table = 'servicio_imagenes';

    protected $fillable = [
        'servicio_id',
        'ruta',
        'nombre_original',
    ];

    public function servicio()
    {
        return $this->belongsTo(Servicio::class);
    }
}
