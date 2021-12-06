<?php
include("funciones.php");

autenticado();
if($_SESSION['role'] == 1){
    header($ruta."Portada.php");
}
else if(!isset($_POST['titulo']) || !isset($_FILES['imagen'])){
    header($ruta."agregarImagenDirecto.php?err=1");
}
else if($_POST['titulo']==""){
    header($ruta."agregarImagenDirecto.php?err=2");
}
else if(!empty($_FILES['imagen']['tmp_name'])){
    $nombre = $_FILES['imagen']['name'];
    $tipo = $_FILES['imagen']['type'];
    $nombretmp = $_FILES['imagen']['tmp_name'];
    $tamano = $_FILES['imagen']['size'];
    $titulo = $_POST['titulo'];
    $id = $_GET['id'];
    //Leer archivos
    $fp = fopen($nombretmp,"r");
    $contenido = fread($fp,$tamano);
    fclose($fp);

    //transformar caracteres especiales
    $contenido = addslashes($contenido);

    //Insertar a la base de datos
    $conexion = conectarBD();
    $qry = "INSERT INTO `imagenes`(`title`, `created_at`, `idprod`, `tipo`, `originalname`, `content`) VALUES 
                                    ('".$_POST['titulo']."',now(),'$id','$tipo','$nombre','$contenido');";
    mysqli_query($conexion, $qry);
    mysqli_close($conexion);
    header($ruta."agregarImagenDirecto.php?err=0&id=$id");
}

?>