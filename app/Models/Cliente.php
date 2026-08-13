<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use App\Models\Cotizacion;

class Cliente extends Model
{
    protected $fillable = [
        'nombre',
        'empresa',
        'ruc',
        'telefono',
        'email',
        'direccion',
    ];

    public function cotizaciones()
{
    return $this->hasMany(Cotizacion::class, 'cliente_id');
}
}