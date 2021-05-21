<?php
    include('../includes/conexionmysqli.php'); //Conecta a la base de datos

    $idAgente = $_POST['CCODAGE'];
    
    $query="SELECT * FROM AGENTES WHERE CCODAGE = '$idAgente'";
    $execute = mysqli_query($DB,$query);

    header('Content-Type: text/txt; charset=utf-8');
    while($fila=mysqli_fetch_array($execute)){
        $data[]=$fila;
    }
    $jsonData=json_encode($data);
    echo $jsonData;