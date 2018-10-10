<?php

namespace App;

use App\Transformers\CargoTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Cargo extends Model
{
    use SoftDeletes;

    public $transformer = CargoTransformer::class;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nombre',
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
