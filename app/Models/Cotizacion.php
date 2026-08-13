<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cotizacion extends Model
{
    protected $table = 'cotizaciones';

    protected $fillable = [
        'cliente_id',
        'numero',
        'fecha',
        'validez',
        'subtotal',
        'descuento',
        'igv',
        'total',
        'estado',
        'observaciones',
    ];

    public function cliente()
    {
        return $this->belongsTo(Cliente::class, 'cliente_id');
    }

    public function detalles()
{
    return $this->hasMany(DetalleCotizacion::class, 'cotizacion_id');
}
}