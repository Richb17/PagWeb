<?php
    include("include/funciones.php");
    autenticado();
    //Se verifica que los datos enviados sean correctos
    if( !isset($_POST['album']) || !isset($_POST['artista'])|| 
        !isset($_POST['precio']) || !isset($_POST['formato'])||
        !isset($_POST['stock']) || !isset($_POST['descripcion'])){
            header($ruta."agregarProducto.php?err=1");
    }
    else if( $_POST['album'] == "" || $_POST['artista'] == "" || 
        $_POST['precio'] == "" || $_POST['formato'] == ""||
        $_POST['stock'] == "" || $_POST['titulo'] == ""){
        header($ruta."agregarProducto.php?err=2");
    }
    else if(!empty($_FILES['imagen']['tmp_name'])){
        extract($_POST);
        $nombre = $_FILES['imagen']['name'];
        $tipo = $_FILES['imagen']['type'];
        $nombretmp = $_FILES['imagen']['tmp_name'];
        $tamano = $_FILES['imagen']['size'];
        //Leer archivos
        $fp = fopen($nombretmp,"r");
        $contenido = fread($fp,$tamano);
        fclose($fp);

        //transformar caracteres especiales
        $contenido = addslashes($contenido);
        $conexion = conectarBD();

        //ejecución de la consulta en la BD
        $consulta = "INSERT INTO `stock`(`id`, `quantity`, `created_at`, `modified_at`, `name`) VALUES (NULL,'$stock',now(),now(),'$album-$artista-$formato');";
        mysqli_query($conexion, $consulta);

        $consulta = "SELECT * FROM `stock` WHERE `name` = '$nombreStock'";
        $res = mysqli_query($conexion, $consulta);
        $rs = mysqli_fetch_array($res);
        $consulta = "INSERT INTO `productos`(`idprod`, `albumname`, `prices`, `description`, `created_at`, `modified_at`, `idstock`, `iddiscount`, `genre`, `format`, `artistname`) VALUES 
                                            (NULL,'$album','$precio','$descripcion',now(),now(),'".$rs['id']."', NULL,'$genero','$formato','$artista');";
        mysqli_query($conexion, $consulta);

        $consulta = "SELECT `idprod` FROM `productos` WHERE `albumname` = '$album' AND `format` = '$formato';";
        $res = mysqli_query($conexion, $consulta);
        $rs = mysqli_fetch_array($res);
        $id = $rs['idprod'];
        $qry = "INSERT INTO `imagenes`(`title`, `created_at`, `idprod`, `tipo`, `originalname`, `content`) VALUES 
                                    ('$titulo',now(),'$id','$tipo','$nombre','$contenido');";
        mysqli_query($conexion, $qry);

        mysqli_close($conexion);
        
        header($ruta."agregarProducto.php?err=0");
    }
?>
