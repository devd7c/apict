<?php

namespace App;

use App\Transformers\PatronalTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Patronal extends Model
{
    use SoftDeletes;

    public $transformer = PatronalTransformer::class;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'sarp',
        'provivienda',
        'infocal',
        'cnss',
        'sip',
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
