<?php
    include('Cajero.class.php');
    $cajero = new Cajero;
    try{
        $cajero->depositar(2, 500);
        $cajero->depositar(100, 100);
        $cajero->depositar(5, 10);
        $cajero->extraer(950);
    }catch (Exception $e){
        echo 'Exception: ' . $e->getMessage();
    }