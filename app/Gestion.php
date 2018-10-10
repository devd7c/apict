<?php

namespace App;

use App\Transformers\GestionTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Gestion extends Model
{
    use SoftDeletes;

    public $transformer = GestionTransformer::class;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'periodo_inicio',
        'periodo_rango',
        'activo',
        'empresa_id',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function periodos()
    {
        return $this->hasMany(Periodo::class);
    }

    public function rcivas()
    {
        return $this->hasMany(Rciva::class);
    }

    public function descuentos()
    {
        return $this->hasMany(Descuento::class);
    }

    public function bonos()
    {
        return $this->hasMany(Bono::class);
    }

    public function horas()
    {
        return $this->hasMany(Hora::class);
    }

    public function multas()
    {
        return $this->hasMany(Multa::class);
    }

    public function domingos()
    {
        return $this->hasMany(Domingo::class);
    }
}
