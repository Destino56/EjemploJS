<?php

    foreach($_POST as $nombre_campo => $valor){
        $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
        eval($asignacion);
    }
    include('../includes/conexionmysqli.php'); //Conecta a la base de datos

    $cargaPrecios = "UPDATE `ARTICULOS`
                    SET `NPVP`= '$PVP' * 0.79,`NPREMAYOR`='$mayorista',`NPCONIVA`='$PVP',`NPMCONIVA`='$mayorista'*1.21,
                        `NPVP_CANARIAS`='$PVP'*0.79,`NPREMAYOR_CANARIAS`='$mayorista',`NPCONIVA_CANARIAS`='$PVP',
                        `NPMCONIVA_CANARIAS`= '$mayorista'*1.21
                    WHERE CREF = '$inp_CREF'";
    $execute = mysqli_query($DB,$cargaPrecios);

?>