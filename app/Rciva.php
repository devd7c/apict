<?php

namespace App;

use App\Transformers\RcivaTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Rciva extends Model
{
    use SoftDeletes;

    public $transformer = RcivaTransformer::class;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'haber_basico',
        'sueldo',
        'saldo',
        'factura',
        'ans',
        'sueldo_neto',
        'smn2',
        'base_imponible',
        'debito_fiscal',
        'credito_fiscal',
        'smn2_iva',
        'saldo_anterior',
        'saldo_anterior_actualizado',
        'saldo_anterior_nuevo',
        'impuesto_periodo',
        'credito_fiscal_dependiente',
        'gestion_id',
        'periodo_id',
        'empleado_id',
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

    public static function salarioMinimoForm110($haberBasico)
    {
        if ($haberBasico > 9440){
            return 'true';
        }else {
            return 'false';
        }
    }
}
