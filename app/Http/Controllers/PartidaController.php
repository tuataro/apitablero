<?php

namespace App\Http\Controllers;

use App\Models\Logs_partides;
use Illuminate\Http\Request;
use App\Models\Partida;


class PartidaController extends Controller
{

    public function store(Request $request)
    {
        $tablero =TaulerController::vector($request->x,$request->y);
        $comprovem = Partida::where('sessid', $request->sessid)->limit(1)->get();
        if(isset($comprovem[0]['id'])){
            return 'error - partida creada';
        }else{
            $partida = new Partida();
            $partida->sessid = $request->sessid;
            $partida->x = $tablero['x'];
            $partida->y = $tablero['y'];
            $partida->tablero = json_encode($tablero['mapa']);
            $partida->save();
        }
        return 'Partida creada';
    }
    //Aqui el cos del programa, posem direccio,
    public function moviment(Request $request)
    {
        $partida = Partida::where('sessid', $request->sessid)->limit(1)->get();
        $var['x'] = $request->x;
        $var['y'] = $request->y;
        //agrupem totes les direccions a un array
        $var['d'] = str_split($request->d);
        //enviem a la cerca
        $resposta = TaulerController::cerca($var, $partida);
        return json_encode($resposta);
    }

    public function registre($id)
    {
        $logs_fets = Logs_partides::select('obstacle','moviment','direccio')->where('sessid', $id)->get();
        return $logs_fets;

    }

}
