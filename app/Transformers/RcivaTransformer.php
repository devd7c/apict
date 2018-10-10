<?php

namespace App\Transformers;

use App\Rciva;
use League\Fractal\TransformerAbstract;

class RcivaTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Rciva $rciva)
    {
        return [
            'id' => (int)$rciva->id,
            'haberBasico' => (float)$rciva->haber_basico,
            'sueldo' => (float)$rciva->sueldo,
            'saldo' => (float)$rciva->saldo,
            'montoEnFactura' => (float)$rciva->factura,
            'aporteNacional' => (float)$rciva->ans,
            'sueldoNeto' => (float)$rciva->sueldo_neto,
            'smn2' => (float)$rciva->smn2,
            'baseImponible' => (float)$rciva->base_imponible,
            'debitoFiscal' => (float)$rciva->debito_fiscal,
            'creditoFiscal' => (float)$rciva->credito_fiscal,
            'smn2Iva' => (float)$rciva->smn2_iva,
            'saldoAnterior' => (float)$rciva->saldo_anterior,
            'saldoAnteriorActualizado' => (float)$rciva->saldo_anterior_actualizado,
            'saldoAnteriorNuevo' => (float)$rciva->saldo_anterior_nuevo,
            'impuestoPeriodo' => (float)$rciva->impuesto_periodo,
            'creditoFiscalDependiente' => (float)$rciva->credito_fiscal_dependiente,
            'idGestion' => (int)$rciva->gestion_id,
            'idPeriodo' => (int)$rciva->periodo_id,
            'idDependiente' => (int)$rciva->empleado_id,
            'creado' => (string)$rciva->created_at,
            'modificado' => (string)$rciva->updated_at,
            'eliminado' => isset($rciva->deleted_at) ? (string) $rciva->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'haberBasico' => 'haber_basico',
            'sueldo' => 'sueldo',
            'saldo' => 'saldo',
            'montoEnFactura' => 'factura',
            'aporteNacional' => 'ans',
            'sueldoNeto' => 'sueldo_neto',
            'smn2' => 'smn2',
            'baseImponible' => 'base_imponible',
            'debitoFiscal' => 'debito_fiscal',
            'creditoFiscal' => 'credito_fiscal',
            'smn2Iva' => 'smn2_iva',
            'saldoAnterior' => 'saldo_anterior',
            'saldoAnteriorActualizado' => 'saldo_anterior_actualizado',
            'saldoAnteriorNuevo' => 'saldo_anterior_nuevo',
            'impuestoPeriodo' => 'impuesto_periodo',
            'creditoFiscalDependiente' => 'credito_fiscal_dependiente',
            'idGestion' => 'gestion_id',
            'idPeriodo' => 'periodo_id',
            'idDependiente' => 'empleado_id',
            'creado' => 'created_at',
            'modificado' => 'updated_at',
            'eliminado' => 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
