<?php

    foreach($_POST as $nombre_campo => $valor){
        $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
        eval($asignacion);
    }

    include('../includes/conexionmysqli.php'); //Conecta a la base de datos

    $cargarCREFS="SELECT CREF FROM ARTICULOS";
    $execute = mysqli_query($DB,$cargarCREFS);

    header('Content-Type: text/txt; charset=utf-8');
    while($fila=mysqli_fetch_array($execute)){
        $data[]=$fila;
    }
    $jsonData=json_encode($data);
    echo $jsonData;
?>
