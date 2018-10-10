<?php

namespace App;

use App\Transformers\PsueldoTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Psueldo extends Model
{
    use SoftDeletes;

    public $transformer = PsueldoTransformer::class;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'categoria',
        'obrero',
        'jubilado',
        'dias_pagados',
        'horas_pagados',
        'haber_basico',
        'antiguedad',
        'bono_antiguedad',
        'thoras',
        'tdomingos',
        'tbonos',
        'tmultas',
        'tdescuentos',
        'tsip',
        'trciva',
        'liquido_pagable',
        'empleado_id',
        'sucursal_id',
        'contrato_id',
        'puesto_id',
        'cargo_id',
        'proceso_id',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }

    public function puesto()
    {
        return $this->belongsTo(Puesto::class);
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public function proceso()
    {
        return $this->belongsTo(Proceso::class);
    }
}
