<?php

    use PHPUnit\Framework\TestCase;

    include('class/Cajero.php');
    $cajero = new Cajero;
    try{
        var_dump($cajero->depositar('ARS', 20, 500));
        var_dump($cajero->depositar('ARS',20, 100));
        var_dump($cajero->depositar('USD',20, 50));
        var_dump($cajero->depositar('ARS',20, 20));
        var_dump($cajero->depositar('EUR',20, 100));
        var_dump($cajero->extraer(99, 200));
    }catch (InvalidParameterException $e){
        echo 'InvalidParameter: ' . $e->getMessage();
    }catch (CurrencyException $e){
        echo 'Currency: ' . $e->getMessage();
    }catch (DenominationException $e){
        echo 'Denomination: ' . $e->getMessage();
    }catch (QuantityException $e){
        echo 'Quantity: ' . $e->getMessage();
    }catch (BalanceException $e){
        echo 'Balance: ' . $e->getMessage();
    }catch (Exception $e){
        echo 'Exception: ' . $e->getMessage();
    }