<?php

namespace App;

use App\Transformers\TdomingoTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tdomingo extends Model
{
    use SoftDeletes;

    public $transformer = TdomingoTransformer::class;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'cantidad',
        'monto',
        'fecha',
        'descripcion',
        'domingo_id',
    ];

    public function domingos()
    {
        return $this->belongsTo(Empresa::class);
    }
}
