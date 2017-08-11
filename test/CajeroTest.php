<?php


use PHPUnit\Framework\TestCase;

/**
 * @covers Cajero
 */
final class CajeroTest extends TestCase{

    public function testDepositarOk() {
        $cajero = new Cajero;
        $res = $cajero->depositar('ars', 20, 100);
        print("{$res['message']}\n");
        $this->assertEquals(200, $res['code']);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Parametros invalidos
     */
    public function testDepositarErrorParams() {
        $cajero = new Cajero;
        print("Parametros invalidos\n");
        $this->expectException($cajero->depositar(999,'asd', 'asd'));
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Denominacion invalida.
     */
    public function testDepositarErrorValue() {
        $cajero = new Cajero;
        print("Denominacion invalida\n");
        $this->expectException($cajero->depositar('dlr',10, 15));
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage La cantidad de billetes a depositar excede la permitida.
     */
    public function testDepositarErrorMaxCapacity() {
        $cajero = new Cajero;
        print("La cantidad de billetes a depositar excede la permitida\n");
        $this->expectException($cajero->depositar('eur', 1900, 20));
    }

    public function testExtraerOk() {
        $cajero = new Cajero;
        $cajero->depositar('eur',20, 50);
        $res = $cajero->extraer('eur', 100);
        print("{$res['message']}\n");
        $this->assertEquals(200, $res['code']);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Parametros invalidos
     */
    public function testExtraerErrorParams() {
        $cajero = new Cajero;
        print("Parametros invalidos\n");
        $this->expectException($cajero->extraer(999, 'asd'));
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Disculpe en este momento de esa cantidad de efectivo.
     */
    public function testExtraerErrorMaxCapacity() {
        $cajero = new Cajero;
        print("Supera la capacidad maxima de extraccion\n");
        $this->expectException($cajero->extraer('dlr', 100));
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Disculpe no tenemos el cambio suficiente para realizar la extracion.
     */
    public function testExtraerErrorChange() {
        $cajero = new Cajero;
        print("Disculpe no tenemos el cambio suficiente para realizar la extracion\n");
        $cajero->depositar('ars', 20, 20);
        $this->expectException($cajero->extraer('ars', 50));
    }

    public function testConsolidarSaldo() {
        $cajero = new Cajero;
        print("Consolidar Saldo\n");
        $res = $cajero->depositar('ars', 20, 100);
        $saldoInicial = $res['saldo'];
        $res = $cajero->extraer('ars', 1000);
        $saldoFinal = $res['saldo'];
        $this->assertEquals($saldoFinal, $saldoInicial - 1000);
    }
}