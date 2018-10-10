<?php

namespace App\Transformers;

use App\Pafiliado;
use League\Fractal\TransformerAbstract;

class PafiliadoTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Pafiliado $pafiliado)
    {
        return [
            'id' => (int)$pafiliado->id,
            'diasCotizados' => (string)$pafiliado->dias_cotizados,
            'afiliacion' => (string)$pafiliado->afiliacion,
            'edad' => (string)$pafiliado->edad,
            'tgmenor65Depsip' => (float)$pafiliado->tgmenor65_depsip,
            'tgmayor65Depsip' => (float)$pafiliado->tgmayor65_depsip,
            'tgmenor65Asegnosip' => (float)$pafiliado->tgmenor65_asegnosip,
            'tgmayor65Asegsip' => (float)$pafiliado->tgmayor65_asegsip,
            'cotizacionAdicional' => (float)$pafiliado->cotizacion_adicional,
            'idEmpleado' => (int)$pafiliado->empleado_id,
            'idProceso' => (int)$pafiliado->proceso_id,
            'creado' => (string)$pafiliado->created_at,
            'modificado' => (string)$pafiliado->updated_at,
            'eliminado' => isset($pafiliado->deleted_at) ? (string) $pafiliado->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'diasCotizados' => 'dias_cotizados',
            'afiliacion' => 'afiliacion',
            'edad' => 'edad',
            'tgmenor65Depsip' => 'tgmenor65_depsip',
            'tgmayor65Depsip' => 'tgmayor65_depsip',
            'tgmenor65Asegnosip' => 'tgmenor65_asegnosip',
            'tgmayor65Asegsip' => 'tgmayor65_asegsip',
            'cotizacionAdicional' => 'cotizacion_adicional',
            'idEmpleado' =>'empleado_id',
            'idProceso' =>'proceso_id',
            'creado' => 'created_at',
            'modificado' => 'updated_at',
            'eliminado' => 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
