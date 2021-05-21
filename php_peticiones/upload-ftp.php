<?php

    $cref = $_POST["inp_CREFS"];

    //echo $cref;

    $connection = ftp_connect("hosting.ftpcomputers.info");
    $login = ftp_login($connection, "antonioalonso_ftpagentes_u", "bzbMtbMDS5#");
    if( (!$connection) || (!$login)){
        echo 'No se pudo conectar';
    }else{
       
        $temp = explode(".", $_FILES['upload']['name']);
        $source_file = $_FILES['upload']['tmp_name'];
        $destino_nombre = "web/imgs/producto/" . $cref . ".jpg";
        //$destino_nombre = "web/" . $cref . ".jpg";
     
        //$nombre=$_FILES['upload']['name'];
        $upload = ftp_put($connection, $destino_nombre, $source_file, FTP_BINARY);

        //SCRIPT PARA QUE EL SUBMIT NO VAYA A OTRA PAGINA Y HAGA UN ALERT
        if ($upload){
            echo "<script>
                window.location= '../actualizarStock.php'
                alert('Imagen actualizada');
            </script>";
        }else{
            echo "<script>
                window.location= '../actualizarStock.php'
                alert('No se ha podido actualizar la imagen');
            </script>";
        }
    }

   
    
    //header("Location: ../actualizarStock.php");
?>
