<?php

namespace App;

use App\Transformers\PeriodoTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Periodo extends Model
{
    use SoftDeletes;

    public $transformer = PeriodoTransformer::class;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'inicio_mes',
        'fin_mes',
        'procesado',
        'cierre',
        'cierre_ufv',
        'gestion_id',
    ];

    public function gestion()
    {
        return $this->belongsTo(Gestion::class);
    }

    public function regperiodos()
    {
        return $this->hasMany(Regperiodo::class);
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
