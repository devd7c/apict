<?php

namespace App;

use App\Transformers\EmpresaTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empresa extends Model
{
    use SoftDeletes;

    public $transformer = EmpresaTransformer::class;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'nombre',
        'nit',
        'nombre_rep_legal',
        'titulo_rep_legal',
        'tipo_doc',
        'nro_doc',
        'exp_doc',
    ];

    public function empleados()
    {
        return $this->hasMany(Empleado::class);
    }

    public function sucursals()
    {
        return $this->hasMany(Sucursal::class);
    }

    public function gestions()
    {
        return $this->hasMany(Gestion::class);
    }

    public function laborals()
    {
        return $this->hasMany(Laboral::class);
    }

    public function patronals()
    {
        return $this->hasMany(Patronal::class);
    }
}
