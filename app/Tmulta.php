<?php

namespace App;

use App\Transformers\TmultaTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tmulta extends Model
{
    use SoftDeletes;

    public $transformer = TmultaTransformer::class;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'monto',
        'fecha',
        'descripcion',
        'multa_id',
    ];

    public function multa()
    {
        return $this->belongsTo(Multa::class);
    }
}
