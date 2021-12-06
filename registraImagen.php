<?php
include("funciones.php");
autenticado();

if($_SESSION['role'] == 1){
    header($ruta."Portada.php");
}
else if(!isset($_POST['album']) || !isset($_POST['formato']) || !isset($_POST['titulo']) || !isset($_FILES['imagen'])){
    header($ruta."subirImagen.php?err=1");
}
else if($_POST['album']== "" || $_POST['formato']=="" || $_POST['titulo']==""){
    header($ruta."subirImagen.php?err=2");
}
else if(!empty($_FILES['imagen']['tmp_name'])){
    $nombre = $_FILES['imagen']['name'];
    $tipo = $_FILES['imagen']['type'];
    $nombretmp = $_FILES['imagen']['tmp_name'];
    $tamano = $_FILES['imagen']['size'];
    $titulo = $_POST['titulo'];

    //Leer archivos
    $fp = fopen($nombretmp,"r");
    $contenido = fread($fp,$tamano);
    fclose($fp);

    //transformar caracteres especiales
    $contenido = addslashes($contenido);

    //Insertar a la base de datos
    $conexion = conectarBD();

    $consulta = "SELECT `idprod` FROM `productos` WHERE `albumname` = '".$_POST['album']."' AND `format` = '".$_POST['formato']."';";
    $res = mysqli_query($conexion, $consulta);
    if(mysqli_num_rows($res) > 0){
        $rs = mysqli_fetch_array($res);
        $id = $rs['idprod'];
        
        $qry = "INSERT INTO `imagenes`(`title`, `created_at`, `idprod`, `tipo`, `originalname`, `content`) VALUES 
                                    ('".$_POST['titulo']."',now(),'$id','$tipo','$nombre','$contenido');";
        mysqli_query($conexion, $qry);
        mysqli_close($conexion);
        header($ruta."subirImagen.php?err=0");
    }
    else{
        header($ruta."subirImagen.php?err=3");
    }
    mysqli_close($conexion);
}

?>