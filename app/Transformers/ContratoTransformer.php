<?php

namespace App\Transformers;

use App\Contrato;
use League\Fractal\TransformerAbstract;

class ContratoTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Contrato $contrato)
    {
        return [
            'id' => (int)$contrato->id,
            'nombre' => (string)$contrato->nombre,
            'descripcion' => (string)$contrato->descripcion,
            'creado' => (string)$contrato->created_at,
            'modificado' => (string)$contrato->updated_at,
            'eliminado' => isset($contrato->deleted_at) ? (string) $contrato->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id'=> 'id',
            'nombre'=> 'nombre',
            'descripcion'=> 'descripcion',
            'creado'=> 'created_at',
            'modificado'=> 'updated_at',
            'eliminado'=> 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
