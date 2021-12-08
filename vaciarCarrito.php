<?php
    include("funciones.php");
    autenticado();
    
    if($_GET['id']==""){
        header($ruta."Portada.php");
    }
    echo $_GET['id'];
    $conexion = conectarBD();
    $res = $conexion->query("SELECT `id_user` FROM `carritos` WHERE `id`=".$_GET['id']);
    $resArr = $res->fetch_array(MYSQLI_ASSOC);
    
    if($_SESSION['idusuario'] != $resArr['id_user']){
        header($ruta."Portada.php");
    }
    
    vaciarCarrito($_GET['id']);
    header($ruta."verCarrito.php");
?>