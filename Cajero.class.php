<?php

class Cajero {

    private $billetes = array(
        '10' => 0,
        '20' => 0,
        '50' => 0,
        '100' => 0,
        '500' => 0,
    );

    private $maximaPorBillete = 1000;
    private $maxBilleteDeposito = 100;
    private $extraccionMaxima = 1000;

    public function depositar($cant, $denominacion){
        if(!is_int($cant) || !is_int($denominacion)){
            throw new Exception ('Parametros invalidos, los 2 parametros deben ser de tipo "integer"');
        }
        if(!array_key_exists($denominacion, $this->billetes)){
            throw new Exception ('Denominacion invalida.');
        }
        if($this->maxBilleteDeposito < $cant){
            throw new Exception ('La cantidad de billetes a depositar excede la permitida.');
        }
        if($this->getCapacidadRestante($denominacion) < $cant){
            throw new Exception ('Disculpe en este momento no podemos realizar la operacion.');
        }
        $this->billetes[$denominacion] += $cant;
        $response = array(
            'code' => 200,
            'message' => 'Su deposito por $' . $cant * $denominacion . ' se realizo correctamente.'
        );
        return $response;
    }

    public function extraer($monto){
        if(!is_int($monto)){
            throw new Exception ('Parametro invalido, el parametro debe ser de tipo "integer"');
        }
        $total = $this->getEfectivoTotal();
        $resto = $monto;
        if($this->extraccionMaxima < $monto){
            throw new Exception ('Supera la capacidad maxima de extraccion.');
        }
        if($total < $monto){
            throw new Exception ('Disculpe en este momento de esa cantidad de efectivo.');
        }
        $modulo = 1;
        $billetesPorDenaminacion = array();
        foreach ($this->getBilletes() as $denominacion => $cantidadBilletes){
            if($modulo != 0 || $resto >= $denominacion){
                $modulo = $resto % $denominacion;
                $billetesAUtilizar = (int) ($resto / $denominacion);
                if($billetesAUtilizar <= $cantidadBilletes){
                    $resto -= ($billetesAUtilizar * $denominacion);
                    if($billetesAUtilizar > 0){
                        $billetesPorDenaminacion[$denominacion] = $billetesAUtilizar;
                    }
                }
            }else{
                exit;
            }
        }
        if($resto === 0){
            $this->restarBilletes($billetesPorDenaminacion);
        }else{
            throw new Exception ('Disculpe no tenemos el cambio suficiente para realizar la extracion.');
        }

        $response = array(
            'code' => 200,
            'message' => 'Su extraccion por $' . $monto . ' se realizo correctamente.'
        );

        return $response;
    }

    private function getCapacidadRestante($denominacion) {
        return $this->maximaPorBillete - $this->billetes[$denominacion];
    }

    private function getEfectivoTotal(){
        $total = 0;
        foreach ($this->billetes as $denominacion => $cantidadBilletes){
            $total += ($denominacion * $cantidadBilletes);
        }
        return $total;
    }

    private function getBilletes(){
        $billetes = array();
        foreach ($this->billetes as $denominacion => $cantidadBilletes){
            if($cantidadBilletes > 0){
                $billetes[$denominacion] = $cantidadBilletes;
            }
        }
        krsort($billetes);
        return $billetes;
    }

    private function restarBilletes($billetes){
        foreach ($billetes as $denominacion => $cantidadBilletes){
            $this->billetes[$denominacion] -= $cantidadBilletes;
        }
    }
}