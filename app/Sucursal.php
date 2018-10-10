<?php

namespace App;

use App\Transformers\SucursalTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Sucursal extends Model
{
    use SoftDeletes;

    public $transformer = SucursalTransformer::class;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nombre',
        'direccion',
        'nit',
        'ciudad',
        'fono',
        'nro_pat',
        'empresa_id',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function empleados()
    {
        return $this->hasMany(Empleado::class);
    }

    public function psueldos()
    {
        return $this->hasMany(Psueldo::class);
    }
}
