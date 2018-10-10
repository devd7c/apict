<?php

namespace App;

use App\Transformers\TdescuentoTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tdescuento extends Model
{
    use SoftDeletes;

    public $transformer = TdescuentoTransformer::class;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'monto',
        'fecha',
        'descripcion',
        'descuento_id',
    ];

    public function descuento()
    {
        return $this->belongsTo(Descuento::class);
    }
}
