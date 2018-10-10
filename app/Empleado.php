<?php

namespace App;

use App\Transformers\EmpleadoTransformer;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Empleado extends Model
{
    use SoftDeletes;

    public $transformer = EmpleadoTransformer::class;

    protected $dates = ['deleted_at'];

    protected $fillable = [
        'tipo_doc',
        'nro_doc',
        'exp_doc',
        'afiliacion',
        'nua_cua',
        'ap_paterno',
        'ap_materno',
        'ap_casada',
        'nombre',
        'nacionalidad',
        'fecha_nacimiento',
        'sexo',
        'jubilado',
        'fecha_ingreso',
        'fecha_retiro',
        'haber_basico',
        'nro_matricula',
        'categoria',
        'domicilio',
        'obrero',
        'empresa_id',
        'sucursal_id',
        'contrato_id',
        'puesto_id',
        'cargo_id',
    ];

    public function empresa()
    {
        return $this->belongsTo(Empresa::class);
    }

    public function sucursal()
    {
        return $this->belongsTo(Sucursal::class);
    }

    public function contrato()
    {
        return $this->belongsTo(Contrato::class);
    }

    public function puesto()
    {
        return $this->belongsTo(Puesto::class);
    }

    public function cargo()
    {
        return $this->belongsTo(Cargo::class);
    }

    public function rcivas()
    {
        return $this->hasMany(Rciva::class);
    }

    public function descuentos()
    {
        return $this->hasMany(Descuento::class);
    }

    public function bonos()
    {
        return $this->hasMany(Bono::class);
    }

    public function horas()
    {
        return $this->hasMany(Hora::class);
    }

    public function multas()
    {
        return $this->hasMany(Multa::class);
    }

    public function domingos()
    {
        return $this->hasMany(Domingo::class);
    }

    public function psueldos()
    {
        return $this->hasMany(Psueldo::class);
    }

    public function pafiliados()
    {
        return $this->hasMany(Pafiliado::class);
    }
}
