<?php

namespace App;

use App\Transformers\TbonoTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Tbono extends Model
{
    use SoftDeletes;

    public $transformer = TbonoTransformer::class;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'monto',
        'fecha',
        'descripcion',
        'bono_id',
    ];

    public function bono()
    {
        return $this->belongsTo(Bono::class);
    }
}
