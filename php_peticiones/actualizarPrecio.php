<?php

//clase para actualizar los precios de la base de datos
    foreach($_POST as $nombre_campo => $valor){
        $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
        eval($asignacion);
    }
    include('../includes/conexionmysqli.php'); //Conecta a la base de datos

    $cargaPrecios = "UPDATE ARTICULOS
                    SET NPVP= $pvp * 0.79, NPREMAYOR = $mayorista , NPCONIVA = $pvp , NPMCONIVA = $mayorista *1.21,
                         NPVP_CANARIAS = $pvp *0.79, NPREMAYOR_CANARIAS = $mayorista , NPCONIVA_CANARIAS = $pvp,
                         NPMCONIVA_CANARIAS =  $mayorista *1.21, NCODCAT = '$NCODCAT', CCODFAM = '$CCODFAM'
                    WHERE CREF = '$inp_CREFS'";
    $execute = mysqli_query($DB,$cargaPrecios);

?>