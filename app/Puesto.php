<?php

namespace App;

use App\Transformers\PuestoTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Puesto extends Model
{
    use SoftDeletes;

    public $transformer = PuestoTransformer::class;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'name',
        'descripcion',
    ];

    public function empleados()
    {
        return $this->hasMany(Empleado::class);
    }

    public function psueldos()
    {
        return $this->hasMany(Psueldo::class);
    }
}
