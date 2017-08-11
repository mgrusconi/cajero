<?php

    use PHPUnit\Framework\TestCase;

    include('class/Cajero.php');
    $cajero = new Cajero;
    try{
        var_dump($cajero->depositar(20, 500));
        var_dump($cajero->depositar(20, 100));
        var_dump($cajero->depositar(20, 50));
        var_dump($cajero->depositar(20, 20));
        var_dump($cajero->depositar(20, 100));
        var_dump($cajero->extraer(950));
    }catch (Exception $e){
        echo 'Exception: ' . $e->getMessage();
    }