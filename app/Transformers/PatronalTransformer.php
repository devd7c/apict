<?php

namespace App\Transformers;

use App\Patronal;
use League\Fractal\TransformerAbstract;

class PatronalTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Patronal $patronal)
    {
        return [
            'id' => (int)$patronal->id,
            'seguroRiesgoAccidenteProf' => (float)$patronal->sarp,
            'provivienda' => (float)$patronal->provivienda,
            'infocal' => (float)$patronal->infocal,
            'cnss' => (float)$patronal->cnss,
            'aportePatronalSolidario' => (float)$patronal->sip,
            'activo' => (int)$patronal->activo,
            'idEmpresa' => (int)$patronal->empresa_id,
            'creado' => (string)$patronal->created_at,
            'modificado' => (string)$patronal->updated_at,
            'eliminado'=> isset($patronal->deleted_at) ? (string) $patronal->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'seguroRiesgoAccidenteProf' => 'sarp',
            'provivienda' => 'provivienda',
            'infocal' => 'infocal',
            'cnss' => 'cnss',
            'aportePatronalSolidario' => 'sip',
            'activo' => 'activo',
            'idEmpresa' => 'empresa_id',
            'creado' => 'created_at',
            'modificado' => 'updated_at',
            'eliminado'=> 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
