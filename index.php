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
        var_dump($cajero->extraer('ARS', 200));
    }catch (Exception $e){
        echo 'Exception: ' . $e->getMessage();
    }