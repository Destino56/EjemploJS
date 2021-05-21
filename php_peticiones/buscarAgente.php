<?php
    include('../includes/conexionmysqli.php'); //Conecta a la base de datos

    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];

    
    $query="SELECT * FROM AGENTES WHERE CNBRAGE LIKE '$nombre%' AND CAPEAGE LIKE '$apellidos%'" ;
    $execute = mysqli_query($DB,$query);

    header('Content-Type: text/txt; charset=utf-8');
    while($fila=mysqli_fetch_array($execute)){
        $data[]=$fila;
    }
    $jsonData=json_encode($data);
    echo $jsonData;