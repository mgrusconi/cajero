<?php

/**
 * Cajero
 *
 * PHP version 5.6
 *
 * @category Training
 * @author   Marcelo Rusconi <mgrusconi@gmail.com>
 *
 */
class Cajero {

    private $billetes = array(
        'ARS' => array(
            '10' => 0,
            '20' => 0,
            '50' => 0,
            '100' => 0,
            '500' => 0
        ),
        'USD' => array(
            '10' => 0,
            '20' => 0,
            '50' => 0,
            '100' => 0
        ),
        'EUR' => array(
            '10' => 0,
            '20' => 0,
            '50' => 0,
            '100' => 0,
            '200' => 0,
            '500' => 0,
        )
    );
    private $maximaPorBillete = 1000;
    private $maxBilleteDeposito = 100;
    private $extraccionMaxima = array(
        'ARS' => 1000,
        'USD' => 500,
        'EUR' => 400
    );

    /**
     * Realiza un nuevo deposito
     *
     * @param string $moneda, integer $cant,  integer $denominacion
     *
     * @throws \Exception
     *
     * @return \Array
     */
    public function depositar($moneda, $cant, $denominacion){
        if(!is_int($cant) || !is_int($denominacion)  || !is_string($moneda)){
            throw new Exception ('Parametros invalidos');
        }
        $moneda = strtoupper($moneda);
        if(!array_key_exists($moneda, $this->billetes)){
            throw new Exception ('Moneda invalida.');
        }
        if(!array_key_exists($denominacion, $this->billetes[$moneda])){
            throw new Exception ('Denominacion invalida.');
        }
        if($this->maxBilleteDeposito < $cant){
            throw new Exception ('La cantidad de billetes a depositar excede la permitida.');
        }
        if($this->getCapacidadRestante($moneda, $denominacion) < $cant){
            throw new Exception ('Disculpe en este momento no podemos realizar la operacion.');
        }
        $this->billetes[$moneda][$denominacion] += $cant;
        $response = array(
            'code' => 200,
            'message' => 'Su deposito por $' . $moneda . ' ' . $cant * $denominacion . ' se realizo correctamente.',
            'saldo' => $this->getEfectivoTotal($moneda)
        );
        return $response;
    }

    /**
     * Realiza una nueva Extraccion
     *
     * @param string $moneda, integer $monto
     *
     * @throws \Exception
     *
     * @return \Array
     */
    public function extraer($moneda, $monto){
        if(!is_int($monto) || !is_string($moneda)){
            throw new Exception ('Parametros invalidos');
        }
        $moneda = strtoupper($moneda);
        if(!array_key_exists($moneda, $this->billetes)){
            throw new Exception ('Moneda invalida.');
        }
        $total = $this->getEfectivoTotal($moneda);
        $resto = $monto;
        if($this->extraccionMaxima[$moneda] < $monto){
            throw new Exception ('Supera la capacidad maxima de extraccion.');
        }
        if($total < $monto){
            throw new Exception ('Disculpe en este momento de esa cantidad de efectivo.');
        }
        $modulo = 1;
        $billetesPorDenaminacion = array();
        foreach ($this->getBilletes($moneda) as $denominacion => $cantidadBilletes){
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
                break;
            }
        }

        if($resto === 0){
            $this->restarBilletes($moneda, $billetesPorDenaminacion);
        }else{
            throw new Exception ('Disculpe no tenemos el cambio suficiente para realizar la extracion.');
        }

        $response = array(
            'code' => 200,
            'message' => 'Su extraccion por $' . $moneda . ' ' . $monto . ' se realizo correctamente.',
            'saldo' => $this->getEfectivoTotal($moneda)
        );

        return $response;
    }

    /**
     * Retorna la capacidad restante dentro del cajero para guardar billetes
     *
     * @param string $moneda, integer $denominacion
     *
     * @throws \Exception
     *
     * @return integer
     */
    private function getCapacidadRestante($moneda, $denominacion) {
        return $this->maximaPorBillete - $this->billetes[$moneda][$denominacion];
    }

    /**
     * Retorna el total de efectivo dentro del cajero
     *
     * @param string $moneda
     *
     * @throws \Exception
     *
     * @return integer
     */
    private function getEfectivoTotal($moneda){
        $total = 0;
        foreach ($this->billetes[$moneda] as $denominacion => $cantidadBilletes){
            $total += ($denominacion * $cantidadBilletes);
        }
        return $total;
    }

    /**
     * Retorna una matriz con todos Billetes que tengan stock en el cajero
     *
     * @param string $moneda
     *
     * @return Array
     */
    private function getBilletes($moneda){
        $billetes = array();
        foreach ($this->billetes[$moneda] as $denominacion => $cantidadBilletes){
            if($cantidadBilletes > 0){
                $billetes[$denominacion] = $cantidadBilletes;
            }
        }
        krsort($billetes);
        return $billetes;
    }

    /**
     * Metodo que resta los billetes extraidos del cajero
     *
     * @param string $moneda, Array $billetes
     *
     * @return void
     */
    private function restarBilletes($moneda, $billetes){
        foreach ($billetes as $denominacion => $cantidadBilletes){
            $this->billetes[$moneda][$denominacion] -= $cantidadBilletes;
        }
    }
}