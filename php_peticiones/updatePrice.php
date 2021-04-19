<?php

    foreach($_POST as $nombre_campo => $valor){
        $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
        eval($asignacion);
    }
    include('../includes/conexionmysqli.php'); //Conecta a la base de datos

    $cargaPrecios = "SELECT NPCONIVA, NPREMAYOR, CIMAGEN FROM ARTICULOS
                            WHERE CREF = '$inp_CREFS'";
    $execute = mysqli_query($DB,$cargaPrecios);

    while($fila=mysqli_fetch_array($execute)){
        $data[]=$fila;
    }
    $jsonData=json_encode($data);
    echo $jsonData;

?>