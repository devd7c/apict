<?php

namespace App\Transformers;

use App\Tmulta;
use League\Fractal\TransformerAbstract;

class TmultaTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Tmulta $tmulta)
    {
        return [
            'id' => (int)$tmulta->id,
            'monto' => (float)$tmulta->monto,
            'fecha' => (string)$tmulta->fecha,
            'descripcion' => (string)$tmulta->descripcion,
            'idMulta' => (int)$tmulta->multa_id,
            'creado' => (string)$tmulta->created_at,
            'modificado' => (string)$tmulta->updated_at,
            'eliminado' => isset($tmulta->deleted_at) ? (string) $tmulta->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'monto' => 'monto',
            'fecha' => 'fecha',
            'descripcion' => 'descripcion',
            'idMulta' => 'multa_id',
            'creado' => 'created_at',
            'modificado' => 'updated_at',
            'eliminado' => 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
