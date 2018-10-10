<?php

namespace App\Transformers;

use App\Tdescuento;
use League\Fractal\TransformerAbstract;

class TdescuentoTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Tdescuento $tdescuento)
    {
        return [
            'id' => (int)$tdescuento->id,
            'monto' => (float)$tdescuento->monto,
            'fecha' => (string)$tdescuento->fecha,
            'descripcion' => (string)$tdescuento->descripcion,
            'idDescuento' => (int)$tdescuento->descuento_id,
            'creado' => (string)$tdescuento->created_at,
            'modificado' => (string)$tdescuento->updated_at,
            'eliminado' => isset($tdescuento->deleted_at) ? (string) $tdescuento->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'monto' => 'monto',
            'fecha' => 'fecha',
            'descripcion' => 'descripcion',
            'idDescuento' => 'descuento_id',
            'creado' => 'created_at',
            'modificado' => 'updated_at',
            'eliminado' => 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
