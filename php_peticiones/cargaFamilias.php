<?php

    foreach($_POST as $nombre_campo => $valor){
        $asignacion = "\$" . $nombre_campo . "='" . $valor . "';";
        eval($asignacion);
    }

    //recoge las familias dada una categoria

    include('../includes/conexionmysqli.php'); //Conecta a la base de datos

    $cargaCategorias = "SELECT CATEGORIAS.NCODCAT, CATEGORIAS.CNOMCAT ,FAMILIAS.CNOMFAM, FAMILIAS.CCODFAM
        FROM CATEGORIAS INNER JOIN ARTICULOS ON CATEGORIAS.NCODCAT = ARTICULOS.NCODCAT
        INNER JOIN FAMILIAS ON FAMILIAS.CCODFAM = ARTICULOS.CCODFAM
        WHERE CATEGORIAS.NCODCAT = '$CCODCAT' GROUP BY FAMILIAS.CNOMFAM";
    $execute = mysqli_query($DB,$cargaCategorias);

    while($fila=mysqli_fetch_array($execute)){
        $data[]=$fila;
    }
    $jsonData=json_encode($data);
    echo $jsonData;


