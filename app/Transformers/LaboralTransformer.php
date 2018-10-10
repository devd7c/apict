<?php

namespace App\Transformers;

use App\Laboral;
use League\Fractal\TransformerAbstract;

class LaboralTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Laboral $laboral)
    {
        return [
            'id' => (int)$laboral->id,
            'salarioMinNac' => (int)$laboral->smn,
            'cuentaIndividualVejez' => (float)$laboral->civ,
            'seguroInvalidez' => (float)$laboral->si,
            'comsionAFP' => (float)$laboral->comision_afp,
            'provivienda' => (float)$laboral->provivienda,
            'iva' => (float)$laboral->iva,
            'aporteSolidarioAsegurado' => (float)$laboral->asa,
            'aporteAdicional13' => (float)$laboral->ans_13,
            'aporteAdicional25' => (float)$laboral->ans_25,
            'aporteAdicional35' => (float)$laboral->ans_35,
            'calculoBonoAntiguedad1' => (float)$laboral->cba_1,
            'calculoBonoAntiguedad2' => (float)$laboral->cba_2,
            'calculoBonoAntiguedad3' => (float)$laboral->cba_3,
            'calculoBonoAntiguedad4' => (float)$laboral->cba_4,
            'calculoBonoAntiguedad5' => (float)$laboral->cba_5,
            'calculoBonoAntiguedad6' => (float)$laboral->cba_6,
            'calculoBonoAntiguedad7' => (float)$laboral->cba_7,
            'activo' => (int)$laboral->activo,
            'idEmpresa' => (int)$laboral->empresa_id,
            'creado' => (string)$laboral->created_at,
            'modificado' => (string)$laboral->updated_at,
            'eliminado' => isset($laboral->deleted_at) ? (string) $laboral->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'salarioMinNac' => 'smn',
            'cuentaIndividualVejez' => 'civ',
            'seguroInvalidez' => 'si',
            'comsionAFP' => 'comision_afp',
            'provivienda' => 'provivienda',
            'iva' => 'iva',
            'aporteSolidarioAsegurado' => 'asa',
            'aporteAdicional13' => 'ans_13',
            'aporteAdicional25' => 'ans_25',
            'aporteAdicional35' => 'ans_35',
            'calculoBonoAntiguedad1' => 'cba_1',
            'calculoBonoAntiguedad2' => 'cba_2',
            'calculoBonoAntiguedad3' => 'cba_3',
            'calculoBonoAntiguedad4' => 'cba_4',
            'calculoBonoAntiguedad5' => 'cba_5',
            'calculoBonoAntiguedad6' => 'cba_6',
            'calculoBonoAntiguedad7' => 'cba_7',
            'activo' => 'activo',
            'idEmpresa' => 'empresa_id',
            'creado' => 'created_at',
            'modificado' => 'updated_at',
            'eliminado'=> 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
