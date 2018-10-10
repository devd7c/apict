<?php

namespace App;

use App\Transformers\ThoraTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Thora extends Model
{
    use SoftDeletes;

    public $transformer = ThoraTransformer::class;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'cantidad',
        'monto',
        'fecha',
        'descripcion',
        'hora_id',
    ];

    public function hora()
    {
        return $this->belongsTo(Hora::class);
    }
}
