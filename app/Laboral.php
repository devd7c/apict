<?php

namespace App;

use App\Transformers\LaboralTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Laboral extends Model
{
    use SoftDeletes;

    public $transformer = LaboralTransformer::class;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'smn',
        'civ',
        'si',
        'comision_afp',
        'provivienda',
        'iva',
        'asa',
        'ans_13',
        'ans_25',
        'ans_35',
        'cba_1',
        'cba_2',
        'cba_3',
        'cba_4',
        'cba_5',
        'cba_6',
        'cba_7',
        'activo',
        'empresa_id',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function proceso()
    {
        return $this->belongsTo(Proceso::class);
    }
}
