<?php
    include("funciones.php");
    //Se verifica que los datos enviados sean correctos
    if( !isset($_GET['album']) || !isset($_GET['artista'])|| 
        !isset($_GET['precio']) || !isset($_GET['formato'])||
        !isset($_GET['stock']) || !isset($_GET['descripcion'])||
        !isset($_GET['nombreStock'])){
            header($ruta."agregarProducto.php?err=1");
    }
    else if( $_GET['album'] == "" || $_GET['artista'] == "" || 
        $_GET['precio'] == "" || $_GET['formato'] == ""||
        $_GET['stock'] == "" || $_GET['nombreStock'] == ""){
        header($ruta."agregarProducto.php?err=2");
    }
    else{
        extract($_GET);
        $conexion = conectarBD();
        //ejecución de la consulta en la BD
        $consulta = "INSERT INTO `stock`(`id`, `quantity`, `created_at`, `modified_at`, `name`) VALUES (NULL,'$stock',now(),now(),'$nombreStock');";
        mysqli_query($conexion, $consulta);
        $consulta = "SELECT * FROM `stock` WHERE `name` = '$nombreStock'";
        $res = mysqli_query($conexion, $consulta);
        $rs = mysqli_fetch_array($res);
        $consulta = "INSERT INTO `productos`(`idprod`, `albumname`, `prices`, `description`, `created_at`, `modified_at`, `idstock`, `iddiscount`, `genre`, `format`, `artistname`) VALUES 
                                            (NULL,'$album','$precio','$descripcion',now(),now(),'".$rs['id']."', NULL,'$genero','$formato','$artista');";
        mysqli_query($conexion, $consulta);
        mysqli_close($conexion);
        
        header($ruta."agregarProducto.php?err=0");
    }
?>
