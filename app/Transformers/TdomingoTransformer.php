<?php

namespace App\Transformers;

use App\Tdomingo;
use League\Fractal\TransformerAbstract;

class TdomingoTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Tdomingo $tdomingo)
    {
        return [
            'id' => (int)$tdomingo->id,
            'cantidad' => (string)$tdomingo->cantidad,
            'monto' => (float)$tdomingo->monto,
            'fecha' => (string)$tdomingo->fecha,
            'descripcion' => (string)$tdomingo->descripcion,
            'idDomingo' => (int)$tdomingo->domingo_id,
            'creado' => (string)$tdomingo->created_at,
            'modificado' => (string)$tdomingo->updated_at,
            'eliminado' => isset($tdomingo->deleted_at) ? (string) $tdomingo->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'cantidad' => 'cantidad',
            'monto' => 'monto',
            'fecha' => 'fecha',
            'descripcion' => 'descripcion',
            'idDomingo' => 'domingo_id',
            'creado' => 'created_at',
            'modificado' => 'updated_at',
            'eliminado' => 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
