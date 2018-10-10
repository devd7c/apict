<?php

namespace App\Transformers;

use App\Cargo;
use League\Fractal\TransformerAbstract;

class CargoTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Cargo $cargo)
    {
        return [
            'id' => (int)$cargo->id,
            'nombre' => (string)$cargo->nombre,
            'descripcion' => (string)$cargo->descripcion,
            'creado' => (string)$cargo->created_at,
            'modificado' => (string)$cargo->updated_at,
            'eliminado' => isset($cargo->deleted_at) ? (string) $cargo->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'nombre' => 'nombre',
            'descripcion' => 'descripcion',
            'creado' => 'created_at',
            'modificado' => 'updated_at',
            'eliminado' => 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
