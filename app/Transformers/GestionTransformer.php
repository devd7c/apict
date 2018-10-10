<?php

namespace App\Transformers;

use App\Gestion;
use League\Fractal\TransformerAbstract;

class GestionTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Gestion $gestion)
    {
        return [
            'id' => (int)$gestion->id,
            'periodoInicio' => (int)$gestion->periodo_inicio, //Ejem: 2018
            'periodoRango' => (int)$gestion->periodo_rango, //1=Enero-Diciembre, 2=Abril-Marzo 3=Octubre-Septiembre
            'activo' => (int)$gestion->activo, //1=Si, 0=No
            'idEmpresa' => (int)$gestion->empresa_id,
            'creado' => (string)$gestion->created_at,
            'modificado' => (string)$gestion->updated_at,
            'eliminado' => isset($gestion->deleted_at) ? (string) $gestion->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'periodoInicio' => 'periodo_inicio',
            'periodoRango' => 'periodo_rango',
            'activo' => 'activo',
            'idEmpresa' => 'empresa_id',
            'creado' => 'created_at',
            'modificado' => 'updated_at',
            'eliminado' => 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
