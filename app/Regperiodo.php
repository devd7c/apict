<?php

namespace App;

use App\Transformers\RegperiodoTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Regperiodo extends Model
{
    use SoftDeletes;

    public $transformer = RegperiodoTransformer::class;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'fecha',
        'tipo_cambio',
        'ufv',
        'activo',
        'periodo_id',
    ];

    public function periodo()
    {
        return $this->belongsTo(Periodo::class);
    }
}
