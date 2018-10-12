<?php

namespace App\Http\Controllers\Rciva;

use App\Bono;
use App\Descuento;
use App\Empleado;
use App\Gestion;
use App\Hora;
use App\Laboral;
use App\Multa;
use App\Periodo;
use App\Rciva;
use App\Domingo;
use App\Tbono;
use App\Tdescuento;
use App\Tdomingo;
use App\Thora;
use App\Tmulta;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\ApiController;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Response;
use phpDocumentor\Reflection\Types\String_;

class RcivaController extends ApiController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $form110 = Rciva::all();

        return $this->showAll($form110);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        /*$rules = [
            'periodo_id' => 'required|integer|min:1',
            'empleado_id' => 'required|integer|min:1',
        ];*/

        //$this->validate($request, $rules);

        return DB::transaction(function () use ($request) {
            $dependientes = Empleado::all()
                ->where('empresa_id', '=', $request->empresa);

            if ($this->ifActualPeriodo($request->empresa, $request->gestion, $request->periodo) == true) {
                foreach ($dependientes as $dependiente) {
                    $rcivas = Rciva::all()
                        ->where('periodo_id', '=', $request->periodo);
                    //$dependiente = Empleado::find($request->empleado_id);
                    $laboral = Laboral::where('activo', 1)->first();

                    //GENERAR SUELDO AFP+BONOS+DESCUENTOS+ANTIGUEDAD+MULTAS
                    $sueldo = $this->GenerarSueldo($dependiente, $laboral);
                    $aporteNacional = $this->GenerarAporteNacional($sueldo, $laboral);

                    //GENERAR SALDO RCIVA
                    $smn2 = round(($laboral->smn * 2), 2);
                    $afp = round($sueldo * (12.71 / 100), 2);
                    $baseImponible = round((($sueldo - $afp) - $smn2), 2);
                    $sueldoNeto = round($baseImponible + $smn2, 2);
                    $f110 = round(($baseImponible * ($laboral->iva / 100)), 2);
                    $smn13 = round(($smn2 * $laboral->iva / 100), 2);
                    $saldo = round(($f110 - $smn13), 2);

                    //GENERAR MONTO DE FACTURA
                    $factura = $this->GenerarMontoFactura($saldo, $laboral);

                    if (Rciva::salarioMinimoForm110($sueldo) == 'true') {

                        $data = $request->all();
                        $data['gestion_id'] = $request->gestion;
                        $data['periodo_id'] = $request->periodo;
                        $data['empleado_id'] = $dependiente->id;
                        $data['haber_basico'] = $dependiente->haber_basico;
                        $data['sueldo'] = $sueldo;
                        $data['saldo'] = $saldo;
                        $data['factura'] = $factura;
                        $data['ans'] = $aporteNacional;
                        $data['sueldo_neto'] = $sueldoNeto;
                        $data['smn2'] = $smn2;
                        $data['base_imponible'] = $baseImponible;
                        $data['debito_fiscal'] = $f110;
                        $data['credito_fiscal'] = 0;
                        $data['smn2_iva'] = $smn13;
                        $data['saldo_anterior'] = 0;
                        $data['saldo_anterior_actualizado'] = 0;
                        $data['saldo_anterior_nuevo'] = 0;
                        $data['impuesto_periodo'] = 0;
                        $data['credito_fiscal_dependiente'] = 0;

                        $form110 = Rciva::create($data);
                    }
                }

                return response()->json(['data' => 'Se genero exitosamente', 'code' => 201]);
            } else {
                return response()->json(['data' => 'No es el periodo actual', 'code' => 211]);
            }
            //return $this->showAll($dependientes, 201);
            //return $rcivas;
        });
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Rciva  $rciva
     * @return \Illuminate\Http\Response
     */
    public function show(Rciva $rciva)
    {
        return $this->showOne($rciva);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Rciva  $rciva
     * @return \Illuminate\Http\Response
     */
    public function edit(Rciva $rciva)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Rciva  $rciva
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Rciva $rciva)
    {
        return DB::transaction(function () use ($request, $rciva) {

            $rciva->fill($request->only([
                'haber_basico',
                'sueldo',
                'saldo',
                'factura',
                'ans',
                'sueldo_neto',
                'smn2',
                'base_imponible',
                'debito_fiscal',
                'credito_fiscal',
                'smn2_iva',
                'saldo_anterior',
                'saldo_anterior_actualizado',
                'saldo_anterior_nuevo',
                'impuesto_periodo',
                'credito_fiscal_dependiente',
                'gestion_id',
                'periodo_id',
                'empleado_id',
            ]));

            /*if (rciva->isClean()) {
                return $this->errorResponse('Necesitas ingresar otros valores para actualizar', 422);
            }*/

            $rciva->save();
            return $this->showOne($rciva);
            //return rciva;
        });
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Rciva  $rciva
     * @return \Illuminate\Http\Response
     */
    public function destroy(Rciva $rciva)
    {
        $rciva->delete();
        return $this->showOne($rciva);
    }

    public function find(Request $request, Response $response)
    {
        $sortBy[] = $request->input('sort_by');
        $sortOrder[] = $request->input('sort_order');
        $pageSize[] = $request->input('pageSize');

        //$idEmpresa = $request->request->get('state');

        $rcivas = DB::table('rcivas')
            ->select(
                'rcivas.id', 'rcivas.periodo_id', 'rcivas.empleado_id', 'rcivas.gestion_id', 'rcivas.haber_basico', 'rcivas.sueldo', 'rcivas.saldo', 'rcivas.factura',
                'rcivas.ans', 'rcivas.sueldo_neto', 'rcivas.smn2', 'rcivas.base_imponible', 'rcivas.debito_fiscal', 'rcivas.credito_fiscal', 'rcivas.smn2_iva',
                'rcivas.saldo_anterior', 'rcivas.saldo_anterior_actualizado', 'rcivas.saldo_anterior_nuevo', 'rcivas.impuesto_periodo', 'rcivas.credito_fiscal_dependiente',
                DB::raw('CONCAT(empleados.ap_paterno," ",empleados.ap_materno," ",empleados.nombre) as nombre_completo'), 'empleados.empresa_id', 'empresas.nombre as nombre_empresa'
            )
            ->join('gestions','gestions.id','=','rcivas.gestion_id')
            ->join('empleados','empleados.id','=','rcivas.empleado_id')
            ->join('empresas','empresas.id','=','empleados.empresa_id')
            //->groupBy('rcivas.id')
            ->where('rcivas.deleted_at', '=', null) // Ocultar campos eliminados
            ->where(DB::raw("concat_ws(' ', empleados.ap_paterno, empleados.ap_materno, empleados.nombre, rcivas.sueldo)"), "LIKE",  "%" . $request["search"] ."%")
            ->where(function ($query) use ($request) {
                if ($request['empresa'] != null) {
                    $query->where('empresas.id', '=', $request['empresa']);
                }
                if ($request['gestion'] != null) {
                    $query->where('rcivas.gestion_id', '=', $request['gestion']);
                }
                if ($request['periodo'] != null) {
                    $query->where('rcivas.periodo_id', '=', $request['periodo']);
                }
            })
            ->orderBy($sortBy[0], $sortOrder[0])
            ->paginate($pageSize[0]);


        // return response()->json(['data' => $empresas, 'code' => 201]);
        return $rcivas;

    }

    public function GenerarSueldo(Empleado $dependiente, Laboral $laboral)
    {
        $haberBasico = $dependiente->haber_basico;

        //Horas
        $thoras = 0;
        $hora = Hora::where('empleado_id', $dependiente->id)->first();
        if($hora != null) {
            $horas = Thora::all()
                ->where('hora_id', '=', $hora->id);
            foreach ($horas as $hora) {
                $thoras += $hora->monto;
            }
            $haberBasico += $thoras;
        }
        //Domingos
        $tdomingos = 0;
        $domingo = Domingo::where('empleado_id', $dependiente->id)->first();
        if($domingo != null) {
            $domingos = Tdomingo::all()
                ->where('domingo_id', '=', $domingo->id);
            foreach ($domingos as $domingo) {
                $tdomingos += $domingo->monto;
            }
            $haberBasico += $tdomingos;
        }
        //Bonos
        $tbonos = 0;
        $bono = Bono::where('empleado_id', $dependiente->id)->first();
        if($bono != null) {
            $bonos = Tbono::all()
                ->where('bono_id', '=', $bono->id);
            foreach ($bonos as $bono) {
                $tbonos += $bono->monto;
            }
            $haberBasico += $tbonos;
        }
        //Multas
        $tmultas = 0;
        $multa = Multa::where('empleado_id', $dependiente->id)->first();
        if($multa != null) {
            $multas = Tmulta::all()
                ->where('multa_id', '=', $multa->id);
            foreach ($multas as $multa) {
                $tmultas += $multa->monto;
            }
            $haberBasico += $tmultas;
        }
        //Descuentos
        $tdescuentos = 0;
        $descuento = Descuento::where('empleado_id', $dependiente->id)->first();
        if($descuento != null) {
            $descuentos = Tdescuento::all()
                ->where('descuento_id', '=', $descuento->id);
            foreach ($descuentos as $descuento) {
                $tdescuentos += $descuento->monto;
            }
            $haberBasico += $tdescuentos;
        }

        //Bono Antiguedad
        $fechaIngreso = Carbon::parse($dependiente->fecha_ingreso);

        //Dependientes Retirados
        if (!$dependiente->fecha_retiro) {
            $fechaRetiro = Carbon::parse($dependiente->fecha_retiro);
            $antiguedadRetiro = $fechaRetiro->diffInYears($dependiente->fecha_ingreso);

            if ($antiguedadRetiro >= 2 && $antiguedadRetiro <= 4) {
                $bono = ($laboral->smn * 3) * ($laboral->cba_1 / 100);
                $haberBasico += $bono;
            }
            if ($antiguedadRetiro >= 5 && $antiguedadRetiro <= 7) {
                $bono = ($laboral->smn * 3) * ($laboral->cba_2 / 100);
                $haberBasico += $bono;
            }
            if ($antiguedadRetiro >= 8 && $antiguedadRetiro <= 10) {
                $bono = ($laboral->smn * 3) * ($laboral->cba_3 / 100);
                $haberBasico += $bono;
            }
            if ($antiguedadRetiro >= 11 && $antiguedadRetiro <= 14) {
                $bono = ($laboral->smn * 3) * ($laboral->cba_4 / 100);
                $haberBasico += $bono;
            }
            if ($antiguedadRetiro >= 15 && $antiguedadRetiro <= 19) {
                $bono = ($laboral->smn * 3) * ($laboral->cba_5 / 100);
                $haberBasico += $bono;
            }
            if ($antiguedadRetiro >= 20 && $antiguedadRetiro <= 24) {
                $bono = ($laboral->smn * 3) * ($laboral->cba_6 / 100);
                $haberBasico += $bono;
            }
            if ($antiguedadRetiro >= 26) {
                $bono = ($laboral->smn * 3) * ($laboral->cba_7 / 100);
                $haberBasico += $bono;
            }

        } else {
            //Dependientes Activos
            $antiguedad = Carbon::now()->diffInYears($fechaIngreso);

            if ($antiguedad >= 2 && $antiguedad <= 4) {
                $bono = ($laboral->smn * 3) * ($laboral->cba_1 / 100);
                $haberBasico += $bono;
            }
            if ($antiguedad >= 5 && $antiguedad <= 7) {
                $bono = ($laboral->smn * 3) * ($laboral->cba_2 / 100);
                $haberBasico += $bono;
            }
            if ($antiguedad >= 8 && $antiguedad <= 10) {
                $bono = ($laboral->smn * 3) * ($laboral->cba_3 / 100);
                $haberBasico += $bono;
            }
            if ($antiguedad >= 11 && $antiguedad <= 14) {
                $bono = ($laboral->smn * 3) * ($laboral->cba_4 / 100);
                $haberBasico += $bono;
            }
            if ($antiguedad >= 15 && $antiguedad <= 19) {
                $bono = ($laboral->smn * 3) * ($laboral->cba_5 / 100);
                $haberBasico += $bono;
            }
            if ($antiguedad >= 20 && $antiguedad <= 24) {
                $bono = ($laboral->smn * 3) * ($laboral->cba_6 / 100);
                $haberBasico += $bono;
            }
            if ($antiguedad >= 26) {
                $bono = ($laboral->smn * 3) * ($laboral->cba_7 / 100);
                $haberBasico += $bono;
            }
        }
        return round($haberBasico, 2);
    }

    public function GenerarAporteNacional($sueldo, Laboral $laboral)
    {
        $aporteNacional = 0;

        if ($sueldo > 13000) {
            $aporteNacional = ($sueldo - 13000) * ($laboral->ans_13 / 100);
        }
        if ($sueldo > 25000) {
            $aporteNacional = ($sueldo - 25000) * ($laboral->ans_25 / 100);
        }
        if ($sueldo > 35000) {
            $aporteNacional = ($sueldo - 35000) * ($laboral->ans_35 / 100);
        }
        return round($aporteNacional, 2);
    }

    public function GenerarMontoFactura($saldo, Laboral $laboral)
    {
        $factura = $saldo * 100 / $laboral->iva;
        return round($factura, 2);
    }

    public function ifActualPeriodo($empresa, $gestion, $periodo) {

        $rcivas = DB::table('rcivas')
            ->select(
                'rcivas.id', 'rcivas.periodo_id', 'rcivas.empleado_id', 'rcivas.gestion_id'
            )
            ->join('gestions','gestions.id','=','rcivas.gestion_id')
            ->join('empleados','empleados.id','=','rcivas.empleado_id')
            ->join('empresas','empresas.id','=','empleados.empresa_id')
            ->groupBy('rcivas.id')
            ->where('rcivas.deleted_at', '=', null) // Ocultar campos eliminados
            ->where('empresas.id', '=', $empresa)
            ->where('rcivas.gestion_id', '=', $gestion)
            ->where('rcivas.periodo_id', '=', $periodo)
            ->count();

        $date = Carbon::now();

        $gestion = Gestion::all()
            ->find($gestion);

        //$month = date('m', strtotime($periodo->inicio_mes));

        $periodo = Periodo::all()
            ->find($periodo);

        $month = date('m', strtotime($periodo->inicio_mes));


        if ($rcivas == 0 && $gestion->periodo_inicio == $date->year && $month == $date->month) {
            return true;
        } else {
            return false;
        }

    }
}
