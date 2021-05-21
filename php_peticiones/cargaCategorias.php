<?php

    //recoge todas las categorias existentes

    include('../includes/conexionmysqli.php'); //Conecta a la base de datos

    $cargaCategorias = "SELECT NCODCAT, CNOMCAT FROM CATEGORIAS";
    $execute = mysqli_query($DB,$cargaCategorias);

    while($fila=mysqli_fetch_array($execute)){
        $data[]=$fila;
    }
    $jsonData=json_encode($data);
    echo $jsonData;




