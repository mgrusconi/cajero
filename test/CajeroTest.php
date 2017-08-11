<?php


use PHPUnit\Framework\TestCase;

/**
 * @covers Cajero
 */
final class CajeroTest extends TestCase{

    public function testDepositarOk() {
        $cajero = new Cajero;
        $res = $cajero->depositar(20, 100);
        print("{$res['message']}\n");
        $this->assertEquals(200, $res['code']);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Parametros invalidos, los 2 parametros deben ser de tipo "integer"
     */
    public function testDepositarErrorParams() {
        $cajero = new Cajero;
        print("Parametros invalidos, los 2 parametros deben ser de tipo 'integer'\n");
        $this->expectException($cajero->depositar('asd', 'asd'));
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Denominacion invalida.
     */
    public function testDepositarErrorValue() {
        $cajero = new Cajero;
        print("Denominacion invalida\n");
        $this->expectException($cajero->depositar(10, 15));
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage La cantidad de billetes a depositar excede la permitida.
     */
    public function testDepositarErrorMaxCapacity() {
        $cajero = new Cajero;
        print("La cantidad de billetes a depositar excede la permitida\n");
        $this->expectException($cajero->depositar(1900, 20));
    }

    public function testExtraerOk() {
        $cajero = new Cajero;
        $cajero->depositar(20, 50);
        $res = $cajero->extraer(100);
        print("{$res['message']}\n");
        $this->assertEquals(200, $res['code']);
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Parametro invalido, el parametro debe ser de tipo "integer"
     */
    public function testExtraerErrorParams() {
        $cajero = new Cajero;
        print("Parametro invalido, el parametro debe ser de tipo 'integer'\n");
        $this->expectException($cajero->extraer('asd'));
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Disculpe en este momento de esa cantidad de efectivo.
     */
    public function testExtraerErrorMaxCapacity() {
        $cajero = new Cajero;
        print("Supera la capacidad maxima de extraccion\n");
        $this->expectException($cajero->extraer(100));
    }

    /**
     * @expectedException Exception
     * @expectedExceptionMessage Disculpe no tenemos el cambio suficiente para realizar la extracion.
     */
    public function testExtraerErrorChange() {
        $cajero = new Cajero;
        print("Disculpe no tenemos el cambio suficiente para realizar la extracion\n");
        $cajero->depositar(20, 20);
        $this->expectException($cajero->extraer(50));
    }
}