<?php

namespace App\Http\Controllers\PreEvaluacion;


use App\Http\Controllers\Controller;
use App\Models\PreEvaluacion;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use PhpParser\Node\Expr\Empty_;
use Yajra\DataTables\Facades\DataTables;
use Yajra\DataTables\Html\Builder;

class PreEvaluacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    private $request;

    /**
     * Constructor to inject the Request dependency
     */
    public function __construct(Request $request)
    {
        $this->request = $request;
    }


    public function IndexSocia()
    {
        if($this->request->ajax()){

            $userId = auth()->user()->id;
            $Sucursales = DB::table('rsg_usuario_sucursal')->where('IN_usuario_ID',$userId)->pluck('VC_COD_SUCURSAL');
            $query = PreEvaluacion::whereIn('CODREGION', $Sucursales);
            if($this->request->filled('from_date') && $this->request->filled('end_date')){
                $query = $query->whereBetween('fecha',[$this->request->from_date,$this->request->end_date]);
            }
            return DataTables::of($query)->make(true);
        }

        return view('PreEvaluaciones.socia');
    }

    public function IndexBC()
    {
        if($this->request->ajax()){
            $userId = auth()->user()->id;
            $Sucursales = DB::table('rsg_usuario_sucursal')->where('IN_usuario_ID',$userId)->pluck('VC_COD_SUCURSAL');
            $query = PreEvaluacion::whereIn('CODREGION', $Sucursales);
            if($this->request->filled('from_date') && $this->request->filled('end_date')){
                $query = $query->whereBetween('fecha',[$this->request->from_date,$this->request->end_date]);
            }
            return DataTables::of($query)->make(true);
        }
        return view('PreEvaluaciones.bancaComunal');
    }


    public function BuscarPreEvaluacionID(){
        $id = $this->request->id;
        $data = PreEvaluacion::where('CODPREEVALUADOR', '=' , $id)->get();
        return response()->json($data, 200);
    }


    public function StorePreEvaluador(){

            $datos = $this->request->validate(
                [
                    'nombrecompleto' => "required",
                    "bancocomunal" => "required",
                    "monto" => "required",
                    "plazo" => "required",
                    "cuota" => "required",
                    "subneto" => "required",
                    "deudaexterna" => "required",
                    "ingresoneto" => "required",
                    "capacidadpago" => "required"
                ]
            );
            $preEvaluadorResponse = $this->BuscarPreEvaluacionID();
            $preEvaluadorActual = json_decode($preEvaluadorResponse->getContent());

            if(!empty($preEvaluadorActual[0]->fechamodi_actual) ){
                return response()->json([
                    'error' => true,
                    'message'=> 'Operacion rechazada, verifique las fechas.',
                    'data' => '',
                ], 200);
            }

            $fechas =  $this->Fechas(
                $preEvaluadorActual[0]->fecha,
                $preEvaluadorActual[0]->fechamodificada,
                $preEvaluadorActual[0]->fechamodi_actual,
                $preEvaluadorActual[0]->FECHAVIGENCIA
            );

            $NewPreEvaluador = [
                'nombrecompleto' => $datos['nombrecompleto'],
                'bancocomunal' => $datos['bancocomunal'],
                'monto' => $datos['monto'],
                'plazo' => $datos['plazo'],
                'cuota' => $datos['cuota'],
                'subneto' => $datos['subneto'],
                'deudaexterna' => $datos['deudaexterna'],
                'ingresoneto' => $datos['ingresoneto'],
                'capacidadpago' => $datos['capacidadpago'],
                'dni' => $preEvaluadorActual[0]->dni,
                'fecha' => $fechas['fechacreacion'],
                'asesor' => $preEvaluadorActual[0]->asesor,
                'nivelriesgo' => $preEvaluadorActual[0]->nivelriesgo,
                'CODREGION' => $preEvaluadorActual[0]->CODREGION,
                'fechamodificada' => $fechas['fechamodificada'],
                'fechamodi_actual' => $fechas['fechamodi_actual'],
                'FECHAVIGENCIA' => $fechas['FECHAVIGENCIA']
            ];

            $response = PreEvaluacion::create($NewPreEvaluador);

            if($response){
                return response()->json([
                    'error' => false,
                    'message' => 'Pre Evaluador creado exitosamente',
                    'data' => $response
                ], 201);
            }else{
                return response()->json([
                    'error' => false,
                    'message' => 'Error al crear el Pre Evaluador',
                    'data' => '',
                ], 200);
            }

    }

    public function Fechas($fechacreacion , $fechamodificada , $fechamodi_actual , $FECHAVIGENCIA ){

        return empty($fechamodificada) ? array(
            'fechacreacion' => $fechacreacion,
            'fechamodificada' => date('Y-m-d'),
            'fechamodi_actual' => '',
            'FECHAVIGENCIA' => $FECHAVIGENCIA
        ) : array(
            'fechacreacion' => $fechacreacion,
            'fechamodificada' => $fechamodificada,
            'fechamodi_actual' => date('Y-m-d'),
            'FECHAVIGENCIA' => $FECHAVIGENCIA
        );
    }
    public function update(String $id)
    {
        $datos = $this->request->validate(
            [
                "bancocomunal" => "required",
                "monto" => "required",
                "plazo" => "required",
                "cuota" => "required",
                "deudaexterna" => "required",
                "ingresoneto" => "required",
                // "" => "required",
            ]
        );

        PreEvaluacion::where('CODPREEVALUADOR', '=' , $id)->update($datos);
        return view('PreEvaluaciones.ModalBuscaSocia');
    }


}
