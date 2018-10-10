<?php

namespace App;

use App\Transformers\ProcesoTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Proceso extends Model
{
    use SoftDeletes;

    public $transformer = ProcesoTransformer::class;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'empresa_id',
        'gestion_id',
        'periodo_id',
        'regperiodo_id',
        'patronal_id',
        'laboral_id',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function gestion()
    {
        return $this->belongsTo(Gestion::class);
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }

    public function regperiodo()
    {
        return $this->belongsTo(Regperiodo::class);
    }

    public function patronal()
    {
        return $this->belongsTo(Patronal::class);
    }

    public function laroral()
    {
        return $this->belongsTo(Laboral::class);
    }

    public function psueldos()
    {
        return $this->hasMany(Psueldo::class);
    }

    public function pafiliados()
    {
        return $this->hasMany(Pafiliado::class);
    }
}
