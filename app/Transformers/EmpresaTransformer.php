<?php

namespace App\Transformers;

use App\Empresa;
use League\Fractal\TransformerAbstract;

class EmpresaTransformer extends TransformerAbstract
{
    /**
     * A Fractal transformer.
     *
     * @return array
     */
    public function transform(Empresa $empresa)
    {
        return [
            'id' => (int)$empresa->id,
            'nombre' => (string)$empresa->nombre,
            'nit' => (string)$empresa->nit,
            'nombreRepLegal' => (string)$empresa->nombre_rep_legal,
            'tituloRepLegal' => (string)$empresa->titulo_rep_legal,
            'tipoDoc' => (string)$empresa->tipo_doc,
            'nroDoc' => (string)$empresa->nro_doc,
            'expedidoDoc' => (string)$empresa->exp_doc,
            'creado' => (string)$empresa->created_at,
            'modificado' => (string)$empresa->updated_at,
            'eliminado' => isset($empresa->deleted_at) ? (string) $empresa->deleted_at : null,
        ];
    }

    public static function originalAttribute($index)
    {
        $attributes = [
            'id' => 'id',
            'nombre' => 'nombre',
            'nit' => 'nit',
            'nombreRepLegal' => 'nombre_rep_legal',
            'tituloRepLegal' => 'titulo_rep_legal',
            'tipoDoc' => 'tipo_doc',
            'nroDoc' => 'nro_doc',
            'expedidoDoc' => 'exp_doc',
            'creado' => 'created_at',
            'modificado' => 'updated_at',
            'eliminado'=> 'deleted_at',
        ];
        return isset($attributes[$index]) ? $attributes[$index] : null;
    }
}
