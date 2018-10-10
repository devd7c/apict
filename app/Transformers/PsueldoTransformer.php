<?php

namespace App\Transformers;

use App\Psueldo;
use League\Fractal\TransformerAbstract;

class PsueldoTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Psueldo $psueldo)
    {
        return [
            'id' => (int)$psueldo->id,
            'categoria' => (string)$psueldo->categoria,
            'obrero' => (int)$psueldo->obrero,
            'jubilado' => (int)$psueldo->jubilado,
            'diasPagados' => (string)$psueldo->dias_pagados,
            'horasPagados' => (string)$psueldo->horas_pagados,
            'haberBasico' => (float)$psueldo->haber_basico,
            'antiguedad' => (float)$psueldo->antiguedad,
            'bonoAntiguedad' => (float)$psueldo->bono_antiguedad,
            'tHoras' => (float)$psueldo->thoras,
            'tDomingos' => (float)$psueldo->tdomingos,
            'tBonos' => (float)$psueldo->tbonos,
            'tMultas' => (float)$psueldo->tmultas,
            'tDescuentos' => (float)$psueldo->tdescuentos,
            'tSip' => (float)$psueldo->tsip,
            'tRciva' => (float)$psueldo->trciva,
            'liquidoPagable' => (float)$psueldo->liquido_pagable,
            'idEmpleado' => (int)$psueldo->empleado_id,
            'idSucursal' => (int)$psueldo->sucursal_id,
            'idContrato' => (int)$psueldo->contrato_id,
            'idPuesto' => (int)$psueldo->puesto_id,
            'idCargo' => (int)$psueldo->cargo_id,
            'idProceso' => (int)$psueldo->proceso_id,
            'creado' => (string)$psueldo->created_at,
            'modificado' => (string)$psueldo->updated_at,
            'eliminado' => isset($psueldo->deleted_at) ? (string) $psueldo->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'categoria' =>'categoria',
            'obrero' =>'obrero',
            'jubilado' =>'jubilado',
            'diasPagados' =>'dias_pagados',
            'horasPagados' =>'horas_pagados',
            'haberBasico' =>'haber_basico',
            'antiguedad' =>'antiguedad',
            'bonoAntiguedad' =>'bono_antiguedad',
            'tHoras' =>'thoras',
            'tDomingos' =>'tdomingos',
            'tBonos' =>'tbonos',
            'tMultas' =>'tmultas',
            'tDescuentos' =>'tdescuentos',
            'tSip' =>'tsip',
            'tRciva' =>'trciva',
            'liquidoPagable' =>'liquido_pagable',
            'idEmpleado' =>'empleado_id',
            'idSucursal' =>'sucursal_id',
            'idContrato' =>'contrato_id',
            'idPuesto' =>'puesto_id',
            'idCargo' =>'cargo_id',
            'idProceso' =>'proceso_id',
            'creado' => 'created_at',
            'modificado' => 'updated_at',
            'eliminado' => 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
