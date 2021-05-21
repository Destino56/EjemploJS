<?php

    foreach($_POST as $nombre_campo => $valor){
        $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
        eval($asignacion);
    }
    include('../includes/conexionmysqli.php'); //Conecta a la base de datos


    $recogeUltimoId = "SELECT MAX(CCODAGE) as id FROM AGENTES";
    $resultado = mysqli_query($DB,$recogeUltimoId);
    if ($row = mysqli_fetch_row($resultado)) {
        $CCODAGE = trim($row[0]);
    }
    $CCODAGE = $CCODAGE +1;
    if ($CCODAGE<100){
        $CCODAGE = "0" . $CCODAGE;
    }
    $insertAgente = "INSERT INTO agentes(CCODAGE, CNBRAGE, CAPEAGE, CCLVAGE, LCOMPRA, LFERIA, EMAIL, LADMIN, CNACIONALIDAD)
                    VALUES ('$CCODAGE','$id_inpInsertarNombre','$id_inpInsertarApellido','$id_inpInsertarPass',
                            '0','0','$id_inpInsertarEmail','$id_inpInsertarAdmin','$id_inpInsertarCodNac')";
    $execute = mysqli_query($DB,$insertAgente);
