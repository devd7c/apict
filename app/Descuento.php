<?php

namespace App;

use App\Transformers\EmpresaTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Descuento extends Model
{
    use SoftDeletes;

    public $transformer = EmpresaTransformer::class;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'empleado_id',
        'gestion_id',
        'periodo_id',
    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function gestion()
    {
        return $this->belongsTo(Gestion::class);
    }

    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }

    public function tdescuentos()
    {
        return $this->hasMany(Tdescuento::class);
    }
}
