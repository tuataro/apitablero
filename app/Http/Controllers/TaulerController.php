<?php

namespace App\Http\Controllers;

use App\Models\Logs_partides;
use Illuminate\Http\Request;
use App\Models\Partida;
use Illuminate\Routing\controller;

class TaulerController extends Controller
{



    public function vector($H,$V){

        $B= rand(5, $V);
        $total_casellas= $H*$V;
        $j=0;
        $p=0;
        for($i=1;$i <= $total_casellas;$i++){
            $vector[$p][$j]= " "; //Primer pintarem el mapa blanquet
            if($i % $V == 0){
                $p++;
                $j=0;
            }else{
                $j++;
            }
        }
            //Posem obstacles
        $total=1;
        while($total <= $B){
            $h=rand(0,$H-1);
            $v=rand(0,$V-1);
            if ($vector[$h][$v] == "*"){}else{
                $vector[$h][$v] = "*";
                $total++;
            }
        }
        $tablero['x'] = $H;
        $tablero['y'] = $V;
        $tablero['mapa'] = $vector;
        return $tablero;
    }

    public function direccio($var, $direccio,$tornem){
        if($tornem != 1) {
            switch ($direccio) {
                case 'n':
                    $var['x'] = $var['x'] - 1;
                    break;
                case 's':
                    $var['x'] = $var['x'] + 1;
                    break;
                case 'e':
                    $var['y'] = $var['y'] + 1;
                    break;
                case 'w':
                    $var['y'] = $var['y'] - 1;
                    break;
            }
        }else{
            switch($direccio){
                case 'n':
                    $var['x'] = $var['x']+1;
                    break;
                case 's':
                    $var['x'] = $var['x']-1;
                    break;
                case 'e':
                    $var['y'] = $var['y']-1;
                    break;
                case 'w':
                    $var['y'] = $var['y']+1;
                    break;
            }
        }
        return $var;
    }

    public function registre_logs($resposta, $estrc){
        $log = new Logs_partides();
        $log->id_partida = $estrc[0]['id'];
        $log->sessid = $estrc[0]['sessid'];
        $log->moviment = $resposta['mov'];
        $log->direccio = $resposta['direccio'];
        $log->obstacle = $resposta['obs'];
        $log->res = $resposta['res'];
        $log->save();
    }

    public function cerca($dir, $estrc){
        $tornem=0;
        foreach($dir['d'] as $d) {
            $resposta = array();
            $logpos = array();
            $dir = TaulerController::direccio($dir, $d, $tornem);
            $logpos['x'] = $dir['x'];
            $logpos['y'] = $dir['y'];

            if ($dir['x'] < 0 || $dir['x'] >= $estrc[0]['x']) {
                $resposta['mov'] = json_encode($logpos);
                $resposta['direccio'] = $d;
                $resposta['obs'] = "0";
                $resposta['res'] = "Fora del mapa";
                $tornem = 1;
            }

            if ($dir['y'] < 0 || $dir['y'] >= $estrc[0]['y']) {
                    $resposta['mov'] = json_encode($logpos);
                    $resposta['direccio'] = $d;
                    $resposta['obs'] = "0";
                    $resposta['res'] = "Fora del mapa";
                    $tornem = 1;
            }

            if($tornem != 1)
            {
                $mapa = json_decode($estrc[0]['tablero']);
                $casella = $mapa[$dir['x']][$dir['y']];
                if (!empty($casella)) {
                    if ($casella == '*') {
                        $resposta['mov'] = json_encode($logpos);
                        $resposta['direccio'] = $d;
                        $resposta['obs'] = 1;
                        $resposta['res'] = "Obstacle trobar retrocedim posició.";
                        $tornem = 1;
                    } else {
                        $resposta['mov'] = json_encode($logpos);
                        $resposta['direccio'] = $d;
                        $resposta['obs'] = 0;
                        $resposta['res'] = "No hi ha obstacles ni perills.";
                    }
                }
              }

            $dir = TaulerController::direccio($dir, $d, $tornem);
            $tornem=0;
            TaulerController::registre_logs($resposta,$estrc);
        }
        $logs_fets = Logs_partides::select('obstacle','moviment','direccio','posactual')->where('sessid', $estrc[0]['sessid'])->get();
        return $logs_fets;
    }

}
