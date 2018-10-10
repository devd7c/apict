<?php

namespace App\Transformers;

use App\Puesto;
use League\Fractal\TransformerAbstract;

class PuestoTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Puesto $puesto)
    {
        return [
            'id' => (int)$puesto->id,
            'nombre' => (string)$puesto->nombre,
            'descripcion' => (string)$puesto->descripcion,
            'creado' => (string)$puesto->created_at,
            'modificado' => (string)$puesto->updated_at,
            'eliminado' => isset($puesto->deleted_at) ? (string) $puesto->deleted_at : null,
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
