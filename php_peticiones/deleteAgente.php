<?php
    include('../includes/conexionmysqli.php'); //Conecta a la base de datos

    $idAgente = $_POST['idAgente'];
   
    
    $query="DELETE FROM AGENTES  WHERE CCODAGE = '$idAgente'";
    $execute = mysqli_query($DB,$query);

    header('Content-Type: text/txt; charset=utf-8');
    