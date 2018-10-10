<?php

namespace App;

use App\Transformers\PafiliadoTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Pafiliado extends Model
{
    use SoftDeletes;

    public $transformer = PafiliadoTransformer::class;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'dias_cotizados',
        'afiliacion',
        'edad',
        'tgmenor65_depsip',
        'tgmayor65_depsip',
        'tgmenor65_asegnosip',
        'tgmayor65_asegsip',
        'cotizacion_adicional',
        'empleado_id',
        'proceso_id',

    ];

    public function empleado()
    {
        return $this->belongsTo(Empleado::class);
    }

    public function proceso()
    {
        return $this->belongsTo(Proceso::class);
    }
}
